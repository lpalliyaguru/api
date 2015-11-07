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

    public function getPlacesAction(Request $request)
    {
        $placeManager   = $this->get('manager.place');
        $places         = $placeManager->getAll();

        return array(
            "total_count"           => 6964,
            "incomplete_results"    => false,
            'items'                  => $places
        );
    }

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
}
