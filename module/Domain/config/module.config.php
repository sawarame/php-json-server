<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

namespace Domain;

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
