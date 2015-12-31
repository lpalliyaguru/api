<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

class UserManager
{
    protected $documentManager;
    protected $repository;
    protected $properties;

    public function __construct(ManagerRegistry $registryManager)
    {
        $this->documentManager  = $registryManager->getManager();
        $this->repository       = $registryManager->getRepository('AppBundle:User');
    }

    public function getOneByUsername($username)
    {
        return $this->repository->findOneByUsername($username);
    }
}