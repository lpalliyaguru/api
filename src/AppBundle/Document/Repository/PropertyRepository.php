<?php

namespace AppBundle\Document\Repository;

use AppBundle\Document\Place;
use Doctrine\Common\Util\Debug;
use Doctrine\ODM\MongoDB\DocumentRepository;
use GeoJson\Geometry\Point;

class PropertyRepository extends DocumentRepository
{

    public function search(Place $near, $sale, $rent)
    {
        $qb = $this->createQueryBuilder('AppBundle:Property');
        $location = $near->getLocation();

        $properties = $qb
            ->field('location')
            ->near(new Point([$location->coordinates[0], $location->coordinates[1]]))
            ->maxDistance(2000)
            ->getQuery()
            ->execute()
            ->toArray()
        ;

        return $properties;
    }

}