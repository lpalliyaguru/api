<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Common\Util\Debug;
use AppBundle\Document\Property;
use AppBundle\Document\PropertyAsset;
use AppBundle\Document\Location;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\SecurityContext;

class PropertyManager
{
    protected $documentManager;
    protected $repository;
    protected $properties;
    protected $propertyIds;
    protected $tokenStorage;

    public function __construct(ManagerRegistry $registryManager, TokenStorage $tokenStorage)
    {
        $this->documentManager  = $registryManager->getManager();
        $this->repository       = $registryManager->getRepository('AppBundle:Property');
        $this->tokenStorage     = $tokenStorage;
    }

    public function getAll()
    {
        return $this->documentManager->createQueryBuilder('AppBundle:Property')->getQuery()->execute()->toArray();
    }

    public function getOneById($id)
    {
        return $qb = $this->repository->find($id);
    }

    public function addProperty()
    {
        $property = new Property();
        $asset    = new PropertyAsset();
        $location = new Location();
        $landLord = $this->tokenStorage->getToken()->getUser();
        $property->setName('Sample name');
        $property->setDescription('Sample Description');
        $property->setOwner($landLord);
        $asset->setImages(array());
        $property->setAsset($asset);
        $location->type = 'Point';
        $location->coordinates = array(
            103.725337,
            1.352033
        );
        $property->setLocation($location);
        $this->save($property);
        return $property;
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