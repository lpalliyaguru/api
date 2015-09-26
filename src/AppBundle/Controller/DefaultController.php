<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $serializer = $this->get('serializer');
        $commentManager = $this->get('manager.comment');
        $comment = $commentManager->getOneById(1);

        $data = $serializer->serialize($comment, 'json' , SerializationContext::create()->setVersion('2.2.0'));
        return new JsonResponse($data);
    }
}
