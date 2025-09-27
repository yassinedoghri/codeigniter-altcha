<div align="center">

# CodeIgniter ALTCHA 🔥🔄🔒

[![Latest Stable Version](https://poser.pugx.org/yassinedoghri/codeigniter-altcha/v)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)
[![Total Downloads](https://poser.pugx.org/yassinedoghri/codeigniter-altcha/downloads)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)
[![License](https://img.shields.io/github/license/yassinedoghri/codeigniter-altcha?color=green)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)
[![PHP Version Require](https://poser.pugx.org/yassinedoghri/codeigniter-altcha/require/php)](https://packagist.org/packages/yassinedoghri/codeigniter-altcha)

A [CodeIgniter4](https://codeigniter.com/) library for
[altcha](https://altcha.org/), a GDPR, WCAG 2.2 AA, and EAA compliant,
self-hosted CAPTCHA alternative with PoW mechanism.

</div>

---

- [🚀 Getting started](#-getting-started)
  - [0. Prerequisites](#0-prerequisites)
  - [1. Installation](#1-installation)
  - [2. Configure](#2-configure)
- [⚙️ Config reference](#️-config-reference)
- [❤️ Acknowledgments](#️-acknowledgments)
- [📜 License](#-license)

## 🚀 Getting started

### 0. Prerequisites

[Download or install the ALTCHA widget script](https://altcha.org/docs/v2/widget-integration/)
and include it on the pages where you want to display the CAPTCHA.

> [!NOTE]  
> **Installing via a package manager?**
>
> Check out
> [**CodeIgniter Vite 🔥⚡**](https://github.com/yassinedoghri/codeigniter-vite)
> for a fast and simple way to manage JavaScript and TypeScript packages in your
> CodeIgniter 4 projects.

### 1. Installation

1. Install `codeigniter-altcha` using composer:

   ```sh
   composer require yassinedoghri/codeigniter-altcha
   ```

2. Add altcha helper to your Autoload.php file:

   ```php
   public $helpers = [/*...other helpers...*/, 'altcha'];
   ```

3. Render the ALTCHA widget inside your forms using the `altcha_widget()`
   helper:

   ```php
   <form method="POST" action="/your-endpoint">
    <!-- Your form fields go here -->

    <?= altcha_widget() ?>

    <button type="submit">Submit</button>
   </form>
   ```

### 2. Configure

Copy the `Altcha.php` config file from
`vendor/yassinedoghri/codeigniter-altcha/src/Config/` into your project's config
folder and update the namespace to Config. You will also need to have these
classes extend the original classes.

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

## ⚙️ Config reference

// TODO

## ❤️ Acknowledgments

This wouldn't have been possible without the amazing work of the
[CodeIgniter](https://codeigniter.com/) & [altcha-org](https://altcha.org/)
teams.\
**Thank you** 🙏

## 📜 License

Code released under the [MIT License](https://choosealicense.com/licenses/mit/).

Copyright (c) 2025-present, Yassine Doghri
([@yassinedoghri](https://yassinedoghri.com/)).
