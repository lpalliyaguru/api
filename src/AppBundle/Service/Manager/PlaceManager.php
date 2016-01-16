<?php

namespace AppBundle\Service\Manager;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Common\Util\Debug;
use AppBundle\Document\Place;
use AppBundle\Document\Property;
use AppBundle\Document\Location;
use AppBundle\Document\Meta;
use Monolog\Handler\Mongo;

class PlaceManager
{
    public static $iconMap = array(
        'hospital'          => 'fa fa-hospital-o',
        'neighborhood'      => 'fa fa fa-hospital',
        'school'            => 'fa fa-university',
        'point_of_interest' => 'fa fa-hand-pointer-o',
        'lodging'           => 'fa fa-bed',
        'restaurant'        => 'fa fa-glass',
        'establishment'     => 'fa fa-hospital',
        'shopping_mall'     => 'fa fa-shopping-cart',
        'locality'          => 'fa fa-location-arrow',
        'Point'             => 'fa fa-hand-pointer-o',
    );

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

    public function getOneByName($name)
    {
        return $this->repository->findOneBy(array('name' => $name));
    }


    public function getPlacesByIds($list)
    {
        $places = array();
        foreach ($list as $id) {
            $places[] = $this->getOne($id);
        }
        return $places;
    }

    public function getPropertyPlaces($property, $longitude, $latitude)
    {
        $places = $this->getPlaces($latitude.','.$longitude);
        $storedPlaces = array();
        $property->setPlaces(array());

        foreach($places as $key => $placeData) {

            $place              = new Place();
            $duplicatedPlace    = $this->getOneByName($placeData['name']);

            if(is_null($duplicatedPlace)) {
                $place
                    ->setName($placeData['name'])
                    ->setType($placeData['types'][0])
                    ->setIcon(isset(self::$iconMap[$placeData['types'][0]]) ? self::$iconMap[$placeData['types'][0]] : 'fa fa-map-marker');

                if (isset($placeData['geometry']['location'])) {
                    $location = new Location();
                    $location->coordinates[0] = (float)$placeData['geometry']['location']['lng'];
                    $location->coordinates[1] = (float)$placeData['geometry']['location']['lat'];
                    $place->setLocation($location);
                }

                $meta           = new Meta();
                $meta->created  = $meta->updated = new \DateTime();
                $place->setMeta($meta);

                $this->documentManager->persist($place);
                $storedPlaces[] = $place;
                if ($key < 6) {
                    $property->addPlace($place);
                }
            }
            else {
                $storedPlaces[] = $duplicatedPlace;
                $property->addPlace($duplicatedPlace);
            }
        }

        $this->documentManager->persist($property);
        $this->documentManager->flush();

        return $storedPlaces;
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
