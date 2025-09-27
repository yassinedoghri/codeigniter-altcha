<?php

declare(strict_types=1);

if (! function_exists('altcha_widget')) {
    /**
     * Renders the ALTCHA widget web component.
     *
     * @param array<string|int,string> $attributes
     */
    function altcha_widget(array $attributes = [], bool $obfuscationMode = false): string
    {
        $attr = '';
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

        return '<altcha-widget' . ($obfuscationMode ? '' : ' challengeurl="' . url_to(
            'altcha'
        ) . '"') . $attr . '></altcha-widget>';
    }
}
