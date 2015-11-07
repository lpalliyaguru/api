<?php

namespace AppBundle\DataFixtures\MongoDB;


use AppBundle\Document\Location;
use AppBundle\Document\Meta;
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

                $location       = new Location();
                $location->coordinates[0]    = (float)$propertyData['location']['lng'];
                $location->coordinates[1]    = (float)$propertyData['location']['lat'];
                $property->setLocation($location);
            }

            $preferred              = new Preferred();
            $preferred->gender      = 'male';
            $preferred->nationality = 'sri lankan';
            $property->setPreferred($preferred);
            $meta = new Meta();
            $meta->created = $meta->updated = new \DateTime();
            $property->setMeta($meta);
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