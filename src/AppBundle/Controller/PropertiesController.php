<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PropertiesController extends Controller
{

    public function getPropertiesAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $properties = $dm->getRepository('AppBundle:Property')->findAll();

        return array(
            'properties' => $properties,
        );
    }
}