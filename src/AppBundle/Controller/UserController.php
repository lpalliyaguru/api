<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function getUsersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    public function addPostAction()
    {
        $postManager    = $this->get('manager.post');
        $postData       = array(
            'title' => 'Sample title2',
            'content' => 'Sample Content 2'
        );

        $postManager->savePost($postData);
        return $postData;
    }
}
