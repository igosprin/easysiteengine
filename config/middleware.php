<?php
// Middleware registry. A route wires them in explicitly in config/routs.php:
//   'middleware' => ['auth' => ['role' => 'user']]   // name => params (goes into handle() as $params)
return [
    // name => class (extends Easysite\Library\Middleware)
    'aliases' => [
        'auth' => \App\Middleware\AuthMiddleware::class,
    ],
    // names that run on EVERY request (before the route's middleware, with $params = null;
    // if the same middleware is also listed on the route, it runs once, with the route's params)
    'global' => ['auth'],
];
