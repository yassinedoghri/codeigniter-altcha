<?php

declare(strict_types=1);

use CodeIgniterAltcha\Config\Altcha;

if (! function_exists('altcha_widget')) {
    /**
     * Renders the ALTCHA widget web component.
     *
     * @param 'inline'|'floating'|'overlay' $ui
     * @param array<string|int,string> $attributes
     */
    function altcha_widget(string $ui = 'inline', array $attributes = [], string $children = ''): string
    {
        $attr = '';

        if ($ui !== 'inline') {
            $attr .= ' ' . $ui;
        }

        foreach ($attributes as $key => $value) {
            if (is_int($key) && $value !== '') {
                $attr .= ' ' . $value;
                continue;
            }

            if (is_string($key)) {
                // @phpstan-ignore-next-line binaryOp.invalid
                $attr .= ' ' . $key . '="' . esc($value, 'attr') . '"';
            }
        }

        if (! array_key_exists('obfuscate', $attributes)) {
            $attr = ' challengeurl="' . url_to('altcha') . '"' . $attr;
        }

        return '<altcha-widget' . $attr . '>' . $children . '</altcha-widget>';
    }
}

if (! function_exists('altcha_obfuscate_data')) {
    /**
     * Obfuscation employing a proof-of-work (PoW) approach based on symmetric AES encryption.
     *
     * The obfuscated data provided to the widget is encrypted using an encryption key and an
     * initialization vector based on a random number.
     *
     * @param string $key encryption key shared with the client. Defaults to an empty string.
     */
    function altcha_obfuscate_data(string $raw, ?string $key = null, ?bool $promptKey = null): string
    {
        /** @var Altcha $altchaConfig */
        $altchaConfig = config('Altcha');

        if ($key === null) {
            $key = $altchaConfig->obfuscationKey;
        }

        if ($promptKey === null) {
            $promptKey = $altchaConfig->promptObfuscationKey;
        }

        $cacheName = 'altcha-' . hash('md5', $raw . $key . ($promptKey ? '1' : '0'));

        /** @var string|null $obfuscatedData */
        $obfuscatedData = cache($cacheName);
        if ($obfuscatedData === null) {
            $cipher = 'AES-256-GCM';
            $keyHash = hash('sha256', $key, true);

            $ivLength = openssl_cipher_iv_length($cipher);

            // @phpstan-ignore identical.alwaysFalse
            if ($ivLength === false) {
                throw new RuntimeException('Getting cipher iv length failed.');
            }

            /** @var Altcha $altchaConfig */
            $altchaConfig = config('Altcha');

            // generate random iv little-endian bytes, num%256 per byte
            $iv = '';
            $num = random_int(0, $altchaConfig->obfuscationMaxNumber);
            for ($i = 0; $i < $ivLength; $i++) {
                $iv .= chr($num % 256);
                $num = intdiv($num, 256);
            }

            $encryptedData = openssl_encrypt($raw, $cipher, $keyHash, OPENSSL_RAW_DATA, $iv, $tag);

            if (! $encryptedData) {
                throw new RuntimeException('Data encryption failed.');
            }

            $obfuscatedData = base64_encode($encryptedData . $tag);

            if ($key !== '') {
                if ($promptKey) {
                    $obfuscatedData .= '?key=(prompt:Enter Password)';
                } else {
                    $obfuscatedData .= '?key=' . $key;
                }
            }

            cache()
                ->save($cacheName, $obfuscatedData, $altchaConfig->obfuscationPayloadTTL);
        }

        return $obfuscatedData;
    }
}

if (! function_exists('altcha_widget_obfuscate')) {
    /**
     * Renders the ALTCHA widget in obfuscation mode to help you protect sensitive information from bots.
     * Use it to obfuscate email addresses, phone numbers, address.
     *
     * Use `mailto:` or `tel:` for clickable links.
     *
     * Example:
     *
     * ```
     * echo altcha_widget_obfuscate('mailto:hello@example.com');
     * // <altcha-widget obfuscate="HASHED_DATA" floating><button>Click to reveal</button></altcha-widget>
     * ```
     *
     * @param array<string|int,string> $attributes
     */
    function altcha_widget_obfuscate(
        string $data,
        array $attributes = [],
        ?string $customLabel = null,
        ?string $key = null,
        ?bool $promptKey = null
    ): string {
        $obfuscatedData = altcha_obfuscate_data($data, $key, $promptKey);

        if ($customLabel === null) {
            /** @var string $customLabel */
            $customLabel = lang('Altcha.clickToReveal');
        }

        return altcha_widget('floating', [
            'obfuscated' => $obfuscatedData,
            ...$attributes,
        ], '<button>' . $customLabel . '</button');
    }
}
