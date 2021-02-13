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
            Repository\Db\JsonDb::class => Repository\Db\JsonDbFactory::class,
            Service\DataService::class => Service\DataServiceFactory::class,
            Service\Logic\DataLogic::class => Service\Logic\DataLogicFactory::class,
            Service\Logic\JsonDbManagerLogic::class => Service\Logic\JsonDbManagerLogicFactory::class,
        ],
        'aliases' => [
        ],
    ],
    'json_db' => [
        'data_path' => __DIR__ . '/../../../data/db',
    ],
];
