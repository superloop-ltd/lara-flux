<?php

return [
    'host' => env('INFLUXDB_HOST', 'localhost'),
    'port' => env('INFLUXDB_PORT', 8086),

    'username' => env('INFLUXDB_USER', ''),
    'password' => env('INFLUXDB_PASSWORD', ''),

    'ssl' => env('INFLUXDB_SSL', false),
    'verify_ssl' => env('INFLUXDB_VERIFYSSL', false),

    'timeout' => env('INFLUXDB_TIMEOUT', 0),
    'connect_timeout' => env('INFLUXDB_CONNECTION_TIMEOUT', 0),

    'udp' => [
        'enabled' => env('INFLUXDB_UDP_ENABLED', false),
        'port'    => env('INFLUXDB_UDP_PORT', 8086),
    ],
];
