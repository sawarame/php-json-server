<?php

/**
 * @see       https://github.com/sawarame/php-json-server for the canonical source repository
 * @copyright https://github.com/sawarame/php-json-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/sawarame/php-json-server/blob/master/LICENSE.md New BSD License
 */

namespace Domain\Service\Logic;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Domain\Repository\Db\JsonDb;
use Domain\Service\Logic\DataLogic;

class JsonDbManagerLogicFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $options ?: null;
        $jsonDb = $container->get(JsonDb::class);
        $dataLogic = $container->get(DataLogic::class);
        return new $requestedName(
            $jsonDb,
            $dataLogic
        );
    }
}
