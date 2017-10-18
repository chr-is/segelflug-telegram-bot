<?php
namespace Application\Service\Factory;

use Application\Service\TelegramService;
use Application\Service\WeatherService;
use Goutte\Client;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class WeatherServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $goutteClient = new Client();
        $telegramService = new TelegramService();

        return new WeatherService($goutteClient, $telegramService);
    }
}