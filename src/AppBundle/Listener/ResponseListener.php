<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{

    private $mainWebSite;
    private $acceptedHttpMethods;

    public function __construct($mainWebSite, $acceptedHttpMethods)
    {
        $this->mainWebSite          = $mainWebSite;
        $this->acceptedHttpMethods  = $acceptedHttpMethods;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', $this->mainWebSite);
        $event->getResponse()->headers->set('Access-Control-Allow-Methods', $this->acceptedHttpMethods);
    }
}