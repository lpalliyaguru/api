<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{

    private $mainWebSite;

    public function __construct($mainWebSite)
    {
        $this->mainWebSite = $mainWebSite;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', $this->mainWebSite);
    }
}