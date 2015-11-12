<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

class PlaceManager
{

    protected $documentManager;
    protected $repository;

    public function __construct(ManagerRegistry $registryManager)
    {
        $this->documentManager  = $registryManager->getManager();
        $this->repository       = $registryManager->getRepository('AppBundle:Place');
    }

    public function getAll()
    {
        return $this->documentManager->createQueryBuilder('AppBundle:Place')->getQuery()->execute()->toArray();
    }

    public function getByKeyword($keyWord = '')
    {
        $qb =  $this->documentManager->createQueryBuilder('AppBundle:Place');
        $qb
            ->field('name')->equals(new \MongoRegex('/.*'.$keyWord.'.*/i'))
        ;

        $places = $qb->getQuery()->execute()->toArray();
        return $places;
    }

    public function getOne($id)
    {
        return $this->repository->find($id);
    }

    public function getPlacesByIds($list)
    {
        $places = array();
        foreach ($list as $id) {
            $places[] = $this->getOne($id);
        }
        return $places;
    }
}