<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Document\User;
use AppBundle\Form\RegisterType;

class OrganisationController extends Controller
{

    public function getOrganisationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Organisation')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("/organization/add")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function addAction(Request $request)
    {
        $user           = new User();
        $form           = $this->get('form.factory')->create(new RegisterType(), $user);

        return array('form' => $form->createView());
    }
}
