<?php

declare(strict_types=1);

namespace Ngandu\Maxicash\Tests;

use InvalidArgumentException;
use Ngandu\Maxicash\Credential;
use PHPUnit\Framework\TestCase;

/**
 * Class CredentialTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class CredentialTest extends TestCase
{
    public function testConstructor(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');

        $this->assertEquals('merchant_id', $credential->merchantId);
        $this->assertEquals('merchant_key', $credential->merchantKey);
    }

    public function testConstructorEmptyMerchantId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Merchant ID cannot be empty');

        new Credential('', 'merchant_key');
    }

    public function testConstructorEmptyMerchantKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Merchant Key or password cannot be empty');

        new Credential('merchant_id', '');
    }
}
