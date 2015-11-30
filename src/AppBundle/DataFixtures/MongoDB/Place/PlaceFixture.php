<?php

namespace AppBundle\DataFixtures\MongoDB\Place;

use AppBundle\Document\Location;
use AppBundle\Document\Meta;
use AppBundle\Document\Place;
use AppBundle\Document\Preferred;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PlaceFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $latlng = file_get_contents($this->container->getParameter('data_dir') . '/places.json');
        $places = $this->getPlaces($latlng);

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

            $manager->persist($place);

        }
        $manager->flush();
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

    public function getOrder()
    {
        return 1;
    }
}
