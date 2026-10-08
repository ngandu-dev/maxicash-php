<?php

declare(strict_types=1);

namespace Ngandu\Maxicash\Tests;

use InvalidArgumentException;
use Ngandu\Maxicash\Credential;
use Ngandu\Maxicash\Data\Currency;
use Ngandu\Maxicash\Data\Language;
use Ngandu\Maxicash\Data\PayType;
use Ngandu\Maxicash\PaymentEntry;
use PHPUnit\Framework\TestCase;

/**
 * Class PaymentEntryTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class PaymentEntryTest extends TestCase
{
    public function testConstructorAmountLessThanZero(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be greater than 0');

        new PaymentEntry(
            credential: $credential,
            amount: -1,
            reference: 'reference',
            acceptUrl: 'https://accept.url',
            declineUrl: 'https://decline.url'
        );
    }

    public function testConstructorRejectsZeroAmount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be greater than 0');

        new PaymentEntry(
            credential: new Credential('merchant_id', 'merchant_key'),
            amount: 0,
            reference: 'reference',
            acceptUrl: 'https://accept.url',
            declineUrl: 'https://decline.url'
        );
    }

    public function testConstructorEmptyReference(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Reference must not be empty');

        new PaymentEntry(
            credential: $credential,
            amount: 100,
            reference: '',
            acceptUrl: 'https://accept.url',
            declineUrl: 'https://decline.url'
        );
    }

    public function testConstructorEmptyAcceptUrl(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Accept url must be a valid url');

        new PaymentEntry(
            credential: $credential,
            amount: 100,
            reference: 'reference',
            acceptUrl: '',
            declineUrl: 'https://decline.url'
        );
    }

    public function testConstructorEmptyDeclineUrl(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Decline url must be a valid url');

        new PaymentEntry(
            credential: $credential,
            amount: 100,
            reference: 'reference',
            acceptUrl: 'https://accept.url',
            declineUrl: ''
        );
    }

    public function testConstructorRejectsInvalidCallbackUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Notify url must be a valid url');

        new PaymentEntry(
            credential: new Credential('merchant_id', 'merchant_key'),
            amount: 100,
            reference: 'reference',
            acceptUrl: 'https://accept.url',
            declineUrl: 'https://decline.url',
            notifyUrl: 'not-a-url'
        );
    }

    public function testConstructorRejectsNonHttpCallbackUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cancel url must be a valid url');

        new PaymentEntry(
            credential: new Credential('merchant_id', 'merchant_key'),
            amount: 100,
            reference: 'reference',
            acceptUrl: 'https://accept.url',
            declineUrl: 'https://decline.url',
            cancelUrl: 'ftp://example.com/cancel'
        );
    }

    public function testPost(): void
    {
        $paymentEntry = new PaymentEntry(
            credential: new Credential('merchantId', 'merchantKey'),
            amount: 100,
            reference: 'reference',
            acceptUrl: 'http://example.com/accept',
            declineUrl: 'http://example.com/decline',
            cancelUrl: 'http://example.com/cancel',
            notifyUrl: 'http://example.com/notify',
            phone: '1234567890',
            email: 'test@example.com',
            payType: PayType::MAXICASH,
            currency: Currency::DOLLAR,
            language: Language::EN
        );

        $expectedResult = [
            'PayType' => 'MaxiCash',
            'Amount' => 100,
            'Currency' => 'maxiDollar',
            'MerchantPassword' => 'merchantKey',
            'MerchantID' => 'merchantId',
            'Language' => 'en',
            'Telephone' => '1234567890',
            'Email' => 'test@example.com',
            'Reference' => 'reference',
            'accepturl' => 'http://example.com/accept',
            'declineurl' => 'http://example.com/decline',
            'cancelurl' => 'http://example.com/cancel',
            'notifyurl' => 'http://example.com/notify',
        ];

        $this->assertEquals($expectedResult, $paymentEntry->post());
    }

    public function testGet(): void
    {
        $paymentEntry = new PaymentEntry(
            credential: new Credential('merchantId', 'merchantKey'),
            amount: 100,
            reference: 'reference',
            acceptUrl: 'http://example.com/accept',
            declineUrl: 'http://example.com/decline',
            cancelUrl: 'http://example.com/cancel',
            notifyUrl: 'http://example.com/notify',
            phone: '1234567890',
            email: 'test@example.com',
            payType: PayType::MAXICASH,
            currency: Currency::DOLLAR,
            language: Language::EN
        );

        $expectedResult =
            '{PayType:"MaxiCash",Amount:"100",Currency:"maxiDollar",Telephone:"1234567890",MerchantID:"merchantId",MerchantPassword:"merchantKey",Language:"en",Reference:"reference",Accepturl:"http://example.com/accept",Cancelurl:"http://example.com/cancel",Declineurl:"http://example.com/decline",NotifyURL:"http://example.com/notify"}';

        $this->assertEquals($expectedResult, $paymentEntry->get());
    }

    public function testGetEscapesValuesAndDefaultsCancelUrl(): void
    {
        $paymentEntry = new PaymentEntry(
            credential: new Credential('merchantId', 'merchantKey'),
            amount: 100,
            reference: 'order "quoted"',
            acceptUrl: 'https://example.com/accept?token=a&source=b',
            declineUrl: 'https://example.com/decline'
        );

        $this->assertSame(
            '{PayType:"MaxiCash",Amount:"100",Currency:"maxiDollar",Telephone:"",MerchantID:"merchantId",MerchantPassword:"merchantKey",Language:"en",Reference:"order \\"quoted\\"",Accepturl:"https://example.com/accept?token=a&source=b",Cancelurl:"https://example.com/decline",Declineurl:"https://example.com/decline",NotifyURL:""}',
            $paymentEntry->get()
        );
    }

    public function testSupportsDocumentedFiatCurrencies(): void
    {
        $this->assertSame('USD', Currency::USD->value);
        $this->assertSame('ZAR', Currency::ZAR->value);
    }
}
