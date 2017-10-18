<?php
namespace Application\Controller\Factory;

use Application\Controller\StreckenflugAtController;
use Application\Service\StreckenflugAtService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class StreckenflugAtControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $streckenflugAtService = $container->get(StreckenflugAtService::class);

        return new StreckenflugAtController($streckenflugAtService);
    }
}