<?php

declare(strict_types=1);

namespace Ngandu\Maxicash\Data;

/**
 * Class Currency.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
enum Currency: string
{
    case DOLLAR = 'maxiDollar';
    case RAND = 'maxiRand';
}
