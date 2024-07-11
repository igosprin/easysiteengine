<?php
//maximum nesting  number 3
//&paramsName - dynamic parametr
return [
    'competition' => [
        'controller' => 'competition',
        'type_method' => 'get',
        'action' => 'index'
    ],
    'competition/&seasonId' => [
        'controller' => 'competition',
        'type_method' => 'get',
        'action' => 'get'
    ],
    'competition/&seasonId/standings' => [
        'controller' => 'user',
        'type_method' => 'get',
        'action' => 'max'
    ],
    'user/&val1/&val2' => [
        'controller' => 'user',
        'type_method' => 'get',
        'action' => 'ffHh'
    ],

];