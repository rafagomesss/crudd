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
                        'list'
                    ],
                ],
                'category' => [
                    'action' => [
                        'edit',
                        'register',
                        'list'
                    ],
                ],
            ],
        ],
    ];

    const RULE_ROUTE_SESSION = [
        'user',
        'expense',
        'category',
        'report'
    ];

    const ONLY_NOT_SESSION = [
        'auth' => [
            'exceptionActions' => [
                'logout'
            ],
        ],
    ];

    const ACCESS_LEVEL = [
        1 => 'ADMIN',
        2 => 'USER'
    ];
}
