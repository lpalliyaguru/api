<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends FOSRestController
{
    /**
     * @Rest\Get("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $response = new JsonResponse(array('success' => true));
        return $response;
    }
}
