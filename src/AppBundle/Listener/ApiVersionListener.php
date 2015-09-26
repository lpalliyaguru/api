<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use JMS\Serializer\Serializer;

class ApiVersionListener
{

    private $serializer;

    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;

    }

    public function onKernelRequest(GetResponseEvent $event)
    {

    }
}