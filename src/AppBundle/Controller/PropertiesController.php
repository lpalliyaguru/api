<?php

namespace AppBundle\Controller;

use AppBundle\Form\PropertyType;
use Doctrine\Common\Util\Debug;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PropertiesController extends Controller
{
	/**
	* @Route("properties")
	*/
    public function getPropertiesAction(Request $request)
    {
        $propertyManager = $this->get('manager.property');
        return array(
            'properties' => $propertyManager->getAll(),
        );
    }

	/**
	* @Route("properties/search")
	*/
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

    public function optionsPropertiesAction($id)
    {
        return array();
    }

    public function putPropertiesAction(Request $request, $id)
    {
        $data = $request->getContent();
        $propertyManager = $this->get('manager.property');
        $property = $propertyManager->getOneById($id);
        $form = $this->createForm(new PropertyType(), $property );
        $form->bind($request);

        if($form->isValid()) {

            $propertyManager->save($property);
            return $property;
        }

		return array('success' => true);
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