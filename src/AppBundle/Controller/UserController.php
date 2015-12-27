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
     * @Get
     * @Route("users/{username}")
     */
    public function getUserAction(Request $request, $username)
    {
        $userManager = $this->get('manager.user');

        $view = $this
            ->view($userManager->getOneByUsername($username), 200)
            ->setTemplate("AppBundle:User:getUser.html.twig")
            ->setTemplateVar('user')
        ;

        return $view;
    }
}
