<?php

declare(strict_types=1);

namespace CodeIgniterAltcha\Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('altcha', '\CodeIgniterAltcha\Controllers\AltchaController::index', [
    'as' => 'altcha',
]);
