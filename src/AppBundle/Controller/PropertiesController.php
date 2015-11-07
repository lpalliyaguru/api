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

    public function getPropertiesSearchAction(Request $request)
    {
        $propertyManager    = $this->get('manager.property');
        $placeManager       = $this->get('manager.place');

        $placeIdList    = $request->query->get('places');
        $rent           = $request->query->get('rent');
        $sale           = $request->query->get('sale');
        $placeIdList    = explode(',', $placeIdList);

        return array(
            'properties' => $propertyManager->getAll(),
        );
        /*
        $places = $placeManager->getPlacesByIds($placeIdList);

        $properties = $propertyManager->searchProperties($places, $rent, $sale);

        return array(
            'properties' => $properties,
        );*/
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