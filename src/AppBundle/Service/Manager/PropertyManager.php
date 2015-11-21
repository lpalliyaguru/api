<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Common\Util\Debug;

class PropertyManager
{
    protected $documentManager;
    protected $repository;
    protected $properties;
    protected $propertyIds;

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
        $this->properties = $this->propertyIds = array();

        foreach ($places as $place) {
            $properties = $this->repository->search($place, $rent, $sale);
            $this->pushProperties($properties);

        }
        return $this->properties;
    }

    public function pushProperties($properties)
    {
        foreach($properties as $property) {
            if(array_search($property->getId(), $this->propertyIds) === false) {
                $this->properties[] = $property;
                $this->propertyIds[] = $property->getId();
            }
        }
    }

    public function save($property)
    {
        $this->documentManager->persist($property);
        $this->documentManager->flush();
        return true;
    }
}