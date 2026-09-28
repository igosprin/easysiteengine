<?php
//maximum nesting  number 3
//&paramsName - dynamic parametr
return [
    'login' => [
        'controller' => 'login',
        'type_method' => 'get',
        'action' => 'show'
    ],
    'login/submit' => [
        'controller' => 'login',
        'type_method' => 'post',
        'action' => 'submit'
    ],
    'register' => [
        'controller' => 'register',
        'type_method' => 'get',
        'action' => 'show'
    ],
    'register/submit' => [
        'controller' => 'register',
        'type_method' => 'post',
        'action' => 'submit'
    ],
    'logout' => [
        'controller' => 'logout',
        'type_method' => 'get',
        'action' => 'index'
    ],
    'account' => [
        'controller' => 'account',
        'type_method' => 'get',
        'action' => 'show',
        'middleware' => ['auth' => ['role' => 'user']],
        'dir' => 'users'
    ],
];