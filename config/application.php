<?php

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'host' => 'mariadb',
            'user' => 'api',
            'pass' => 'api',
            'dbname' => 'seedapp',
        ],
        'dbtest' => [
            'host' => 'mariadb',
            'user' => 'test',
            'pass' => 'test',
            'dbname' => 'seedapp',
        ],
        'logger' => [
            'name' => 'SeedAppAPI',
            'level' => Logger::INFO,
        ],
    ],
];
