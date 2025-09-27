<?php

declare(strict_types=1);

namespace CodeIgniterAltcha\Config;

use CodeIgniter\Config\BaseService;
use CodeIgniterAltcha\Altcha;

class Services extends BaseService
{
    public static function altcha(bool $getShared = true): Altcha
    {
        if ($getShared) {
            /** @var Altcha */
            return static::getSharedInstance('altcha');
        }

        return new Altcha(config('Altcha'));
    }
}
