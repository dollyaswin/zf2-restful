<?php
namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController
    Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	return new JsonModel();
    }
}
