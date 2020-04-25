<?php

namespace Domain;


use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            Repository\JsonDbImpl::class => Repository\JsonDbFactory::class,
        ],
        'alias' => [
            Repository\JsonDb::class => Repository\JsonDbImpl::class,
        ],
    ],
    'json_db' => [
        'data_path' => __DIR__ . '/../../../data/db',
    ],
];
