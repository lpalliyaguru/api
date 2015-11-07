<?php

namespace AppBundle\Document\Repository;

use AppBundle\Document\Place;
use Doctrine\ODM\MongoDB\DocumentRepository;

class PropertyRepository extends DocumentRepository
{

    public function search(Place $near, $sale, $rent)
    {
        $qb = $this->createQueryBuilder();
        $location = $near->getLocation();

        $properties = $this->createQueryBuilder('Property')
            ->geoNear($location->coordinates[1], $location->coordinates[0])
            ->spherical(true)
            // Convert radians to kilometers (use 3963.192 for miles)
            ->distanceMultiplier(6378.137)
            ->getQuery()
            ->execute();
        return $properties;
    }

}