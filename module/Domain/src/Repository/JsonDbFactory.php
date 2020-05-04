<?php

namespace Domain\Repository;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class JsonDbFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $options ?: null;
        $config = $container->get('config');
        return new $requestedName(
            $config['json_db']
        );
    }
}
