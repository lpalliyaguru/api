<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Common\Util\Debug;
use AppBundle\Document\Place;
use AppBundle\Document\Location;
use AppBundle\Document\Meta;
use Monolog\Handler\Mongo;

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

    public function getPropertyPlaces($longitude,$latitude)
    {
        $places = $this->getPlaces($latitude.','.$longitude);

        foreach($places as $placeData) {

            $place = new Place();
            $place
                ->setName($placeData['name'])
                ->setType($placeData['types'][0])
            ;

            if(isset($placeData['geometry']['location'])) {
                $location       = new Location();
                $location->coordinates[0]    = (float)$placeData['geometry']['location']['lng'];
                $location->coordinates[1]    = (float)$placeData['geometry']['location']['lat'];
                $place->setLocation($location);
            }

            $meta = new Meta();
            $meta->created = $meta->updated = new \DateTime();
            $place->setMeta($meta);

            $this->documentManager->persist($place);
        }

        $this->documentManager->flush();

        return $places;
    }

    private function getPlaces($latlng, $radius = 1000)
    {
        $apiKey = 'AIzaSyCQZd3BoAYuj1bjXxTsVIr4DhyjS6p_pgA';
        $mapUrl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?';
        $params = http_build_query(array(
                'location'  => $latlng,
                'radius'    => $radius,
                'key'       => $apiKey
            )
        );
        try {

            $response = file_get_contents($mapUrl . $params);
            $response = json_decode($response, true);

            if($response['status'] == 'OK') {
                return $response['results'];
            }
        }
        catch (\Exception $e){
            error_log($e->getMessage());
        }

        return array();
    }
}
