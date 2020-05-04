<?php

namespace Application\Controller;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Domain\Service\MainService;

class MainControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $options ?: null;
        $db = $container->get(MainService::class);
        return new $requestedName(
            $db
        );
    }
}
