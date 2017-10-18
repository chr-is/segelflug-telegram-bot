<?php
namespace Application\Service\Factory;

use Application\Service\StreckenflugAtService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TelegramServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new StreckenflugAtService();
    }
}