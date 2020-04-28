<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\Router\Http\Method;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'schema'  => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/:schema',
                    'constraints' => [
                        'schema' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                ],
                'child_routes' => [
                    'fetch' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'get',
                            'defaults' => [
                                'controller' => Controller\MainController::class,
                                'action'     => 'fetch',
                            ],
                        ],
                    ],
                    'create' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'post',
                            'defaults' => [
                                'controller' => Controller\MainController::class,
                                'action'     => 'create',
                            ],
                        ],
                    ],
                ],
            ],
            'item' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/:schema/:id',
                    'constraints' => [
                        'schema'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'           => '[0-9]*',
                    ],
                ],
                'child_routes' => [
                    'find' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'get',
                            'defaults' => [
                                'controller' => Controller\MainController::class,
                                'action'     => 'find',
                            ],
                        ],
                    ],
                    'replace' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'put',
                            'defaults' => [
                                'controller' => Controller\MainController::class,
                                'action'     => 'replace',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'delete',
                            'defaults' => [
                                'controller' => Controller\MainController::class,
                                'action'     => 'delete',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\MainController::class => Controller\MainControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
