<?php

namespace Domain\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Domain\Repository\JsonDb;

class MainServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $options ?: null;
        $db = $container->get(JsonDb::class);
        return new $requestedName(
            $db
        );
    }
}
