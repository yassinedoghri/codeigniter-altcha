<?php

declare(strict_types=1);

namespace CodeIgniterAltcha\Config;

use CodeIgniter\Config\BaseConfig;

class Altcha extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Altcha HMAC secret key
     * --------------------------------------------------------------------------
     *
     * Secret key used for ALTCHA HMAC operations such as challenge signing.
     * Must be at least 24 characters long.
     */
    public string $hmacKey = '';

    /**
     * --------------------------------------------------------------------------
     * Altcha automatically generated HMAC secret key
     * --------------------------------------------------------------------------
     *
     * Use the cache to generate and store the HMAC secret automatically.
     * If cache driver is set to dummy, the $hmacKey will be used instead.
     */
    public bool $autoGenerateHMAC = true;

    /**
     * --------------------------------------------------------------------------
     * Altcha HMAC cache duration
     * --------------------------------------------------------------------------
     *
     * Number of seconds HMAC secret key should be kept in cache.
     */
    public int $hmacKeyTTL = DAY;

    /**
     * --------------------------------------------------------------------------
     * Altcha Redirect
     * --------------------------------------------------------------------------
     *
     * Redirect to previous page with error on failure.
     */
    public bool $redirect = (ENVIRONMENT === 'production');

    /**
     * --------------------------------------------------------------------------
     * Altcha challenge algorithm
     * --------------------------------------------------------------------------
     *
     * @see https://altcha.org/docs/v2/complexity/
     */
    public ?string $challengeAlgorithm = null;

    /**
     * --------------------------------------------------------------------------
     * Altcha challenge max number
     * --------------------------------------------------------------------------
     *
     * @see https://altcha.org/docs/v2/complexity/
     */
    public ?int $challengeMaxNumber = null;

    /**
     * --------------------------------------------------------------------------
     * Altcha challenge expires
     * --------------------------------------------------------------------------
     *
     * @see https://altcha.org/docs/v2/complexity/
     */
    public int $challengeExpires = 10;

    /**
     * --------------------------------------------------------------------------
     * Obfuscation key
     * --------------------------------------------------------------------------
     *
     * Main password to enter for revealing obfuscated data
     *
     * @see https://altcha.org/docs/v2/obfuscation/
     */
    public string $obfuscationKey = '';

    /**
     * --------------------------------------------------------------------------
     * Obfuscation key
     * --------------------------------------------------------------------------
     *
     * Whether or not to ask the user to enter the key for
     * revealing the obfuscated data.
     */
    public bool $promptObfuscationKey = true;

    /**
     * --------------------------------------------------------------------------
     * Obfuscation max number
     * --------------------------------------------------------------------------
     *
     * @see https://altcha.org/docs/v2/obfuscation/
     */
    public int $obfuscationMaxNumber = 10_000;

    /**
     * --------------------------------------------------------------------------
     * Obfuscation Payload TTL
     * --------------------------------------------------------------------------
     */
    public int $obfuscationPayloadTTL = MONTH;
}
