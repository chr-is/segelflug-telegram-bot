<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Service\StreckenflugAtService;
use Zend\Mvc\Controller\AbstractActionController;

class StreckenflugAtController extends AbstractActionController
{
    public function __construct(StreckenflugAtService $streckenflugAtService)
    {
        $this->streckenflugAtService = $streckenflugAtService;
    }

    public function indexAction()
    {
    }

    public function getNewsAction()
    {
        $this->streckenflugAtService->getNews();
        $this->streckenflugAtService->sendNews();

        die();
    }

    public function sendNewsAction()
    {
        $this->streckenflugAtService->sendNews();

        die();
    }
}
