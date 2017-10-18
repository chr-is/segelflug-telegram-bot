<?php
namespace Application\Service\Factory;

use Application\Service\StreckenflugAtService;
use Application\Service\TelegramService;
use Goutte\Client;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\Factory\FactoryInterface;

class StreckenflugAtServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(Adapter::class);
        $goutteClient = new Client();
        $telegramService = new TelegramService();

        return new StreckenflugAtService($adapter, $goutteClient, $telegramService);
    }
}