<?php

namespace Ngandu\Maxicash\Tests;

use Ngandu\Maxicash\Environment;
use PHPUnit\Framework\TestCase;

/**
 * Class EnvironmentTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class EnvironmentTest extends TestCase
{
    public function testGetBaseUrl(): void
    {
        $this->assertEquals(
            'https://api.maxicashapp.com',
            Environment::LIVE->getBaseUrl()
        );
        $this->assertEquals(
            'https://api-testbed.maxicashapp.com',
            Environment::SANDBOX->getBaseUrl()
        );
    }
}
