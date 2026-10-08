<?php

declare(strict_types=1);

namespace Ngandu\Maxicash;

/**
 * Class Environment.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
enum Environment: string
{
    case LIVE = 'prod';
    case SANDBOX = 'dev';

    public function getBaseUrl(): string
    {
        return match ($this) {
            self::LIVE => 'https://api.maxicashapp.com',
            self::SANDBOX => 'https://api-testbed.maxicashapp.com',
        };
    }

    public function getWebApiBaseUrl(): string
    {
        return match ($this) {
            self::LIVE => 'https://webapi.maxicashapp.com',
            self::SANDBOX => 'https://webapi-test.maxicashapp.com',
        };
    }
}
