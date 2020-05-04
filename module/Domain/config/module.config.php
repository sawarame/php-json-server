<?php

namespace Domain;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            Service\MainService::class => Service\MainServiceFactory::class,
            Repository\JsonDbImpl::class => Repository\JsonDbFactory::class,
        ],
        'aliases' => [
            Repository\JsonDb::class => Repository\JsonDbImpl::class,
        ],
    ],
    'json_db' => [
        'data_path' => __DIR__ . '/../../../data/db',
    ],
];
