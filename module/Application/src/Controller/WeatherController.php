<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Service\WeatherService;
use Zend\Mvc\Controller\AbstractActionController;

class WeatherController extends AbstractActionController
{
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function indexAction()
    {
    }

    public function getWeatherAction()
    {
        $this->weatherService->getWeather();

        die();
    }
}
