<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends FOSRestController
{


    /**
     * @Options
     * @Route("users/{username}")
     */
    public function optionsUserAction(Request $request, $username)
    {
        return array();
    }

    /**
     * @Get
     * @Route("users/{id}")
     */
    public function getUserAction(Request $request, $id)
    {
        $userManager = $this->get('manager.user');

        $view = $this
            ->view($userManager->getOne($id), 200)
            ->setTemplate("AppBundle:User:getUser.html.twig")
            ->setTemplateVar('user')
        ;

        return $view;
    }
}
