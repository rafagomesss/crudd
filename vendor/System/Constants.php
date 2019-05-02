<?php
namespace System;

class Constants
{
    const RESTRICT_USER_ROUTE = [
        'USER' => [
            'controller' => [
                'user' => [
                    'action' => [
                        'edit',
                        'register',
                    ],
                ],
            ],
        ],
    ];

    const RULE_ROUTE_SESSION = [
        'user',
    ];

    const ACCESS_LEVEL = [
        1 => 'ADMIN',
        2 => 'USER',
    ];
}
