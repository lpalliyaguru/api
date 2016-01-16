<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class PlacesController extends Controller
{


    /**
     * @Rest\Options("places")
     * @param Request $request
     * @return array
     */
    public function optionsPlacesAction(Request $request)
    {

    }
    /**
     * @Rest\Post("places")
     * @param Request $request
     * @return array
     */
    public function postPlacesAction(Request $request)
    {
        var_dump(__METHOD__);
        exit();
    }

    /**
     * @Rest\Get("places")
     * @param Request $request
     * @return array
     */
    public function getPlacesAction(Request $request)
    {
        $placeManager   = $this->get('manager.place');
        $places         = $placeManager->getAll();

        return array(
            "total_count"           => 6964,
            "incomplete_results"    => false,
            'items'                 => $places
        );
    }

    /**
     * @Rest\Options("places/search")
     * @param Request $request
     * @return array
     */
    public function optionsPlacesSearchAction(Request $request)
    {
        
    }

    /**
     * @Rest\Get("places/search")
     * @param Request $request
     * @return array
     */
    public function getPlacesSearchAction(Request $request)
    {
        $keyWord = $request->query->get('query');

        $placeManager   = $this->get('manager.place');
        $places         = $placeManager->getByKeyword($keyWord);

        return array(
            'success'   => true,
            'data'      => $places
         );
    }

    /**
     * Get the nearest locations of the property
     * @Rest\Options("places/nearby")
     * @param Request $request
     * @return array
     */
    public function optionsPlacesNearByAction(Request $request)
    {

    }

    /**
     * Get the nearest locations of the property
     * @Rest\Get("places/nearby")
     * @param Request $request
     * @return array
     */
    public function getPlacesNearByAction(Request $request)
    {
        $placeManager       = $this->get('manager.place');
        $propertyManager    = $this->get('manager.property');

        $longitude       = $request->query->get('longitude');
        $latitude        = $request->query->get('latitude');
        $propertyId      = $request->query->get('propertyId');

        $property        = $propertyManager->getOneById($propertyId);

        $places = $placeManager->getPropertyPlaces($property, $longitude,$latitude);

        return array(
            'places'   => $places
        );
    }
}

