<?php
return [
    'redis' => [
 
        'client' => env('REDIS_CLIENT', 'phpredis'),
     
        'default' => [
            'host' => env('REDIS_HOST', 'redis-docker'),
            'password' => env('REDIS_PASSWORD',$_SERVER['REDIS_PASSWORD']),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],
     
        'cache' => [
            'host' => env('REDIS_HOST', 'redis-docker'),
            'password' => env('REDIS_PASSWORD',$_SERVER['REDIS_PASSWORD']),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],
     
    ],
    
    
];