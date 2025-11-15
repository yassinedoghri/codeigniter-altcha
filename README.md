<div align="center">
  <img width="180" src="./src/logo.svg" alt="CodeIgniter ALTCHA logo" />

# CodeIgniter ALTCHA 🔥🔄🔒

[![Latest Stable Version](https://poser.pugx.org/yassinedoghri/codeigniter-altcha/v)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)
[![Total Downloads](https://poser.pugx.org/yassinedoghri/codeigniter-altcha/downloads)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)
[![License](https://img.shields.io/github/license/yassinedoghri/codeigniter-altcha?color=green)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)
[![PHP Version Require](https://poser.pugx.org/yassinedoghri/codeigniter-altcha/require/php)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)

A [CodeIgniter4](https://codeigniter.com/) library for
[ALTCHA](https://altcha.org/), a GDPR, WCAG 2.2 AA, and EAA compliant,
self-hosted CAPTCHA alternative with
[Proof‑of‑Work (PoW)](https://en.wikipedia.org/wiki/Proof_of_work) mechanism.

</div>

## Why ALTCHA? <!-- omit in toc -->

- **No frustrating puzzles**. Proof‑of‑Work runs silently in the background.
- **No third‑party calls**. Fully self‑hosted and privacy‑first.
- **Built for real users**: fast, accessible, and open‑source.

👉 See
[10 Reasons ALTCHA Is Better](https://altcha.org/captcha-alternative-why-altcha-is-better/)

## Features <!-- omit in toc -->

- [x] Proof‑of‑Work CAPTCHA (no puzzles; background verification)
  - [x] Server‑side challenge issuance & verification filter for CI4
  - [x] ALTCHA widget helper with auto `challengeurl`
- [x] Proof‑of‑Work data obfuscation (protects emails, phones, and other
      sensitive data)
  - [x] Cached obfuscated payloads to avoid recomputes
  - [x] Obfuscation widget helper with localized reveal label for click to
        reveal
- [ ] [ALTCHA Sentinel](https://altcha.org/docs/v2/sentinel/) (advanced
      detection and metrics)

---

## Table of Contents <!-- omit in toc -->

- [🚀 Getting started](#-getting-started)
  - [0. Prerequisites](#0-prerequisites)
  - [1. Installation](#1-installation)
  - [2. Configuration](#2-configuration)
- [🧩 ALTCHA widgets](#-altcha-widgets)
  - [Render the widget](#render-the-widget)
  - [Render widget in obfuscation mode](#render-widget-in-obfuscation-mode)
- [⚙️ Config reference](#️-config-reference)
- [❤️ Acknowledgments](#️-acknowledgments)
- [📜 License](#-license)

## 🚀 Getting started

### 0. Prerequisites

1. [Download or install the ALTCHA widget script](https://altcha.org/docs/v2/widget-integration/).
2. Include the ALTCHA widget script on any page that renders `<altcha-widget>`

> [!NOTE]  
> **Installing via a package manager?**
>
> Check out
> [**CodeIgniter Vite 🔥⚡**](https://github.com/yassinedoghri/codeigniter-vite)
> for a fast and simple way to manage JavaScript and TypeScript packages in your
> CodeIgniter4 projects.

### 1. Installation

1. Install `codeigniter-altcha` using composer:

   ```sh
   composer require yassinedoghri/codeigniter-altcha
   ```

2. Add `altcha` helper to your Autoload.php file:

   ```php
   public $helpers = [/*...other helpers...*/, 'altcha'];
   ```

3. Enable ALTCHA's server-side verification filter globally in your
   `app/Config/Filters.php` file:

   ```php
   public $globals = [
       'before' => [
           // ...
           'altcha' => [
             'except' => ['api*'] // discard paths for which you want to bypass the ALTCHA verification
           ],
       ],
       // ...
   ];
   ```

4. Render the ALTCHA widget inside your forms using the `altcha_widget()`
   helper:

   ```php
   <form method="POST" action="/your-endpoint">
    <!-- Your form fields go here -->

    <?= altcha_widget() ?>

    <button type="submit">Submit</button>
   </form>
   ```

### 2. Configuration

Copy the `Altcha.php` config file from
`vendor/yassinedoghri/codeigniter-altcha/src/Config/` into your project's config
folder and update the namespace to Config. You will also need to have the class
extend the original class.

```php

// new file - app/Config/Altcha.php
<?php

declare(strict_types=1);

namespace Config;

// ...
use CodeIgniterAltcha\Config\Altcha as CodeIgniterAltcha;

class Altcha extends CodeIgniterAltcha
{
    // ...
}
```

## 🧩 ALTCHA widgets

Two helpers let you render the widget either for user verification or for
revealing obfuscated data.

### Render the widget

Use `altcha_widget()` to render the `<altcha-widget>` element inside your forms,
with optional ui layout, attributes, and children.

See ALTCHA's
[widget customization docs](https://altcha.org/docs/v2/widget-customization/)
for all available options and UI modes.

```php
altcha_widget(string $ui = 'inline', array $attributes = [], string $children = ''): string​`
```

#### Parameters

- `$ui`: `'inline'|'floating'|'overlay'` (default: `'inline'`)
- `$attributes`: `array<int|string, string>` (default: `[]`)
- `$children`: `string` (default: `''`)

#### Examples:

- **inline**

  ```php
  <?= altcha_widget() ?>
  // <altcha-widget></altcha-widget>
  ```

- **floating**

  ```php
  <?= altcha_widget('floating') ?>
  // <altcha-widget floating></altcha-widget>
  ```

- **overlay**

  ```php
  <?= altcha_widget('overlay') ?>
  // <altcha-widget overlay></altcha-widget>
  ```

- **customAttributes**

  ```php
  <?= altcha_widget('inline', ['language' => 'fr']) ?>
  // <altcha-widget language="fr"></altcha-widget>
  ```

### Render widget in obfuscation mode

Use obfuscation to protect emails, phones, or any sensitive data from scrapers;
users click to reveal.

> [!NOTE]  
> No manual setup needed: CodeIgniter ALTCHA generates the obfuscated payload
> for you and wires it into the widget automatically.

> [!IMPORTANT]  
> Obfuscation deters scraping and casual bots; **it does not provide strong
> secrecy**.  
> For sensitive data, avoid embedding it client‑side and return it from the
> server only after verification/authentication.

See
[ATCHA's official docs for obfuscating data](https://altcha.org/docs/v2/obfuscation/).

```php
altcha_widget_obfuscate(string $data, array $attributes = [], ?string $customLabel = null, ?string $key = null, ?bool $promptKey = null): string
```

#### Parameters

- `$data`: `string`
- `$attributes`: `array<int|string, string>` (default: `[]`)
- `$label`: `?string` (default: `null`, uses localized label)
- `$key`: `?string` (default: `null`, uses config value)
- `$promptKey`: `?bool` (default: `null`, uses config value)

#### Examples

- **Email link**

  ```php
  <?= altcha_widget_obfuscate('mailto:hello@example.com') ?>
  ```

- **Phone link**

  ```php
  <?= altcha_widget_obfuscate('tel:+15554441234', [], 'Show phone') ?>
  ```

- **With extra attributes**

  ```php
  <?= altcha_widget_obfuscate('mailto:hello@example.com', ['language' => 'de'], 'Kontakt anzeigen') ?>
  ```

## ⚙️ Config reference

You may control the ALTCHA integration behavior in your CodeIgniter4 app if
needed, including how HMAC secrets are managed, and how challenge parameters are
tuned.

> [!NOTE]  
> This library should be using sensible defaults, you should tweak things only
> if the need arises.

#### `hmacKey`

Type: string

Default: `''` (empty, ie. not defined)

Secret used to sign challenges and verify solutions via HMAC (**Must be at least
24 characters long.**)

For production, set a long, random secret from environment configuration and do
not commit it to source control.

Required when `autoGenerateHMAC` is `false` or when the cache is unavailable.

#### `autoGenerateHMAC`

Type: `boolean`

Default: `true`

When true, an HMAC secret is generated and stored in the configured cache pool.
If the cache driver is “dummy” or cannot persist values, the library falls back
to `hmacKey`.

#### `hmacKeyTTL`

Type: `int` (seconds)

Default: `DAY` (number of seconds in one day)

Lifetime, in seconds, for the auto-generated HMAC secret in cache. When the TTL
expires, a new secret is generated.

#### `redirect`

Type: `boolean`

Default: `(ENVIRONMENT === 'production')`

When true, failures in ALTCHA verification redirect the user back to the
previous page with an error indicator (e.g., flash message) instead of rendering
an inline error response.

By default, enabled in production for better UX and disabled during development
to surface detailed errors inline for easier debugging.

#### `challengeAlgorithm`

Type: `string|null`

Default: `null` (ALTCHA's default)

Optional override for the challenge algorithm used by ALTCHA. When null,
ALTCHA’s default algorithm is used.

Must match the client-side widget expectation; mismatches will cause
verification failures.

Typical values align with ALTCHA complexity options (e.g., `SHA-256`). Refer to
[ALTCHA’s complexity documentation](https://altcha.org/docs/v2/complexity/) for
available algorithms.

#### `challengeMaxNumber`

Type: `int|null`

Default: `null` (ALTCHA's default)

Optional override for the maximum random number used in the proof-of-work search
space. Larger values increase the computational cost for the client.

When `null`, the server uses the library’s default. Set an explicit integer to
tune difficulty for your audience and device profile.

#### `challengeExpires`

Type: `int` (seconds)

Default: `10`

Time window, in seconds, during which a newly issued challenge remains valid on
the server. Submissions outside this window are rejected as expired.

Keep this short to limit replay risk. If legitimate users frequently time out
(e.g., slow forms or long interactions), increase cautiously while balancing
security and UX.

#### `obfuscationKey`

Type: `string`

Default: `''` (empty, ie. not defined)

The optional encryption key used to generate obfuscated data; if configured to
prompt, users must enter this key to reveal the content.

#### `promptObfuscationKey`

Type: `bool`

Default: `true`

Whether users are prompted to enter the obfuscation key before reveal.

#### `obfuscationMaxNumber`

Type: `int`

Default: `10000`

Upper bound of the PoW search range for obfuscation; higher values increase
client work and slow reveals.

#### `obfuscationPayloadTTL`

Type: `int` (seconds)

Default: `MONTH`

Cache lifetime for precomputed obfuscation payloads; when expired, a new payload
is generated.

## ❤️ Acknowledgments

This wouldn't have been possible without the amazing work of the
[CodeIgniter](https://codeigniter.com/) & [altcha-org](https://altcha.org/)
teams.\
**Thank you** 🙏

## 📜 License

Code released under the [MIT License](https://choosealicense.com/licenses/mit/).

Copyright (c) 2025-present, Yassine Doghri
([@yassinedoghri](https://yassinedoghri.com/)).
