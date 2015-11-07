<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

class PropertyManager
{
    protected $documentManager;
    protected $repository;
    protected $properties;

    public function __construct(ManagerRegistry $registryManager)
    {
        $this->documentManager  = $registryManager->getManager();
        $this->repository       = $registryManager->getRepository('AppBundle:Property');
    }

    public function getAll()
    {
        return $this->documentManager->createQueryBuilder('AppBundle:Property')->getQuery()->execute()->toArray();
    }

    public function getOneById($id)
    {
        return $qb = $this->repository->find($id);

    }

    public function searchProperties($places, $rent, $sale)
    {
        $this->properties = array();

        foreach ($places as $place) {
            $places = $this->repository->search($place, $rent, $sale);
            $places = $this->removeDuplicates($places);
            $this->properties = array_merge($this->properties, $places);

        }
    }

    public function removeDuplicates()
    {

    }
}