<?php
namespace Application\Controller\Factory;

use Application\Controller\WeatherController;
use Application\Service\WeatherService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class WeatherControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $weatherService = $container->get(WeatherService::class);

        return new WeatherController($weatherService);
    }
}