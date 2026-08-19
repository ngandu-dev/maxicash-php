<?php

declare(strict_types=1);

namespace Ngandu\Maxicash\Data;

/**
 * Class PayType.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
enum PayType: string
{
    case MAXICASH = 'MaxiCash';
    case BANK_TRANSFER = 'BankTransfer';
    case VISA = 'VISA';
    case MOBILE_MONEY = 'MobileMoney';
}
