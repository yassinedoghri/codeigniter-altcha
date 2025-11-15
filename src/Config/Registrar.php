<?php

declare(strict_types=1);

namespace CodeIgniterAltcha\Config;

use CodeIgniterAltcha\Filters\AltchaFilter;

class Registrar
{
    /**
     * Registers the Altcha filter.
     *
     * @return array{aliases?:array<string,string>,globals?:array{before:array{altcha:array{except:list<string>}}}}
     */
    public static function Filters(): array
    {
        return [
            'aliases' => [
                'altcha' => AltchaFilter::class,
            ],
        ];
    }
}
