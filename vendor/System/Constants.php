<?php
namespace System;

class Constants
{
    const RESTRICT_USER = [
        'ADMIN' => [
            'controller' => [],
            'methods' => []
        ],
        'USER' => [
            'controller' => [
                'user'
            ],
            'methods' => [
                'register',
                'edit'
            ]
        ]
    ];

    const RULE_ROUTE_SESSION = [
        'user'
    ];

    const ACCESS_LEVEL = [
        1 => 'ADMIN',
        2 => 'USER'
    ];
}
