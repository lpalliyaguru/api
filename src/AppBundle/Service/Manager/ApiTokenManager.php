<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

class ApiTokenManager
{
    protected $documentManager;
    protected $repository;

    public function __construct(ManagerRegistry $registryManager)
    {
        $this->documentManager  = $registryManager->getManager();
        $this->repository       = $registryManager->getRepository('AppBundle:AccessToken');
    }

    public function save($accessToken)
    {
        $this->documentManager->persist($accessToken);
        $this->documentManager->flush();
    }

    public function getTokenByAccessToken($token)
    {
        return $this->repository->findOneBy(array('accessToken' => $token));
    }
}