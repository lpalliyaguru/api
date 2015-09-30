<?php

namespace AppBundle\DataFixtures\MongoDB;


use AppBundle\Document\Location;
use AppBundle\Document\Preferred;
use AppBundle\Document\Property;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PropertyFixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $properties = $this->getProperties();

        foreach($properties as $propertyData) {

            $property = new Property();
            $property
                ->setName($propertyData['name'])
                ->setAddress($propertyData['address'])
                ->setCondition($propertyData['condition'])
                ->setDescription($propertyData['description'])
                ->setType($propertyData['type'])
            ;
            if(isset($propertyData['location'])) {
                error_log('adding location');
                $location       = new Location();
                $location->x    = $propertyData['location']['lat'];
                $location->y    = $propertyData['location']['lng'];
                $property->setLocation($location);
            }

            $preferred              = new Preferred();
            $preferred->gender      = 'male';
            $preferred->nationality = 'sri lankan';
            $property->setPreferred($preferred);
            $manager->persist($property);

        }
        $manager->flush();
    }

    private function getProperties()
    {
        $file           = $this->container->getParameter('data_dir') . '/properties.json';
        $properties     = json_decode(file_get_contents($file), true);
        return $properties;
    }

}