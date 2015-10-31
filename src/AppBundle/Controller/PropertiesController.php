<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PropertiesController extends Controller
{

    public function getPropertiesAction(Request $request)
    {
        $propertyManager = $this->get('manager.property');
        return array(
            'properties' => $propertyManager->getAll(),
        );
    }

    public function getPropertiesSearchAction()
    {

    }

    public function postPropertiesAction()
    {

    }

    public function getPropertyAction($id)
    {
        $propertyManager = $this->get('manager.property');
        return array(
            'property' => $propertyManager->getOneById($id)
        );
    }
}