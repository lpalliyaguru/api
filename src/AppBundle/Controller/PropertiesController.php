<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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


        $places = $placeManager->getPlacesByIds($placeIdList);

        $properties = $propertyManager->searchProperties($places, $rent, $sale);

        return array(
            'properties' => $properties,
        );
    }

    public function postPropertiesAction()
    {

    }

    public function getPropertyAction($id)
    {
        $propertyManager = $this->get('manager.property');
        return $propertyManager->getOneById($id);
    }

    public function optionsPropertiesImageAction($id)
    {
        ///sleep(3);
        return array(
            'success' => true,
            'image' => 'http://cdn.e2e.local/images/UPHO.60324451.V550.jpg'
        );
    }
}