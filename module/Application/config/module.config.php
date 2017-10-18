<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\Factory\IndexControllerFactory;
use Application\Controller\Factory\StreckenflugAtControllerFactory;
use Application\Controller\Factory\WeatherControllerFactory;
use Application\Service\Factory\StreckenflugAtServiceFactory;
use Application\Service\Factory\TelegramServiceFactory;
use Application\Service\Factory\WeatherServiceFactory;
use Application\Service\StreckenflugAtService;
use Application\Service\TelegramService;
use Application\Service\WeatherService;
use Zend\Db\Adapter\AdapterAbstractServiceFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            // The segment route does a rather complex matching on the input with a generated regex, while the
            // literal route will do a simple string comparison. This makes it a lot faster and it should be preferred
            // when no parameter matching is required.
            'index' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'get_sat' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/get_sat',
                    'defaults' => [
                        'controller' => Controller\StreckenflugAtController::class,
                        'action'     => 'getNews',
                    ],
                ],
            ],
            'send_sat' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/send_sat',
                    'defaults' => [
                        'controller' => Controller\StreckenflugAtController::class,
                        'action'     => 'sendNews',
                    ],
                ],
            ],
            'get_weather' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/get_weather',
                    'defaults' => [
                        'controller' => Controller\WeatherController::class,
                        'action'     => 'getWeather',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
            Controller\StreckenflugAtController::class => StreckenflugAtControllerFactory::class,
            Controller\WeatherController::class => WeatherControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            StreckenflugAtService::class => StreckenflugAtServiceFactory::class,
            WeatherService::class => WeatherServiceFactory::class,
            TelegramService::class => TelegramServiceFactory::class,
        ]
    ],
    'abstract_factories' => [
        AdapterAbstractServiceFactory::class,
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
    ],
];
