<?php

declare(strict_types=1);

namespace Ngandu\Maxicash\Tests;

use Ngandu\Maxicash\Client;
use Ngandu\Maxicash\Credential;
use Ngandu\Maxicash\Data\Language;
use Ngandu\Maxicash\Environment;
use Ngandu\Maxicash\PaymentEntry;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class ClientTest extends TestCase
{
    public function testDonationUrl(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/donationentry?data=%7BMerchantID%3A%22merchant_id%22%2CLanguage%3A%22en%22%7D',
            $client->donationUrl()
        );

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/donationentry?data=%7BMerchantID%3A%22merchant_id%22%2CLanguage%3A%22fr%22%7D',
            $client->donationUrl(Language::FR)
        );

        $this->assertSame(
            $client->donationUrl(Language::FR),
            $client->donationUrl('fr')
        );
    }

    public function testFormPostPayment(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/PayEntryPost',
            $client->formPostPayment()
        );
    }

    public function testQueryStringURLPayment(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $paymentEntry = new PaymentEntry(
            credential: $credential,
            amount: 100,
            reference: 'reference',
            acceptUrl: 'https://example.com/accept',
            declineUrl: 'https://example.com/cancel',
        );

        $expectedData = '{PayType:"MaxiCash",Amount:"100",Currency:"maxiDollar",Telephone:"",MerchantID:"merchant_id",MerchantPassword:"merchant_key",Language:"en",Reference:"reference",Accepturl:"https://example.com/accept",Cancelurl:"https://example.com/cancel",Declineurl:"https://example.com/cancel",NotifyURL:""}';

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/PayEntry?data=' . rawurlencode($expectedData),
            $client->queryStringURLPayment($paymentEntry)
        );
    }

    public function testPayEntryWeb(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://webapi-test.maxicashapp.com/Integration/PayEntryWeb',
            $client->payEntryWeb()
        );

        $liveClient = new Client($credential, Environment::LIVE);

        $this->assertSame(
            'https://webapi.maxicashapp.com/Integration/PayEntryWeb',
            $liveClient->payEntryWeb()
        );
    }

    public function testPayEntryWebLog(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/payentryweb?logid=id',
            $client->payEntryWebLog('id')
        );
    }

    public function testPayEntryWebLogEncodesTheIdentifier(): void
    {
        $client = new Client(new Credential('merchant_id', 'merchant_key'));

        $this->assertSame(
            'https://api-testbed.maxicashapp.com/payentryweb?logid=id%26status%3Dpaid',
            $client->payEntryWebLog('id&status=paid')
        );
    }
}
