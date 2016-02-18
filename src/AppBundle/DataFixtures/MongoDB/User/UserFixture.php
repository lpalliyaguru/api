<?php

namespace AppBundle\DataFixtures\MongoDB\User;

use AppBundle\Document\Location;
use AppBundle\Document\Meta;
use AppBundle\Document\Place;
use AppBundle\Document\Preferred;

use AppBundle\Document\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    private static $users = array(
        array(
            'username'  => 'lpalliyaguru',
            'email'     => 'pgmlmanoj@gmail.com',
            'firstname' => 'Manoj',
	    'lastname'  => 'Lasantha',
            'type'      => 'LANDLORD',
            'phone'     => '90294521'

        )
    );

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        foreach(self::$users as $userData) {

            $user = new User();
            $user
                ->setFirstName($userData['firstname'])
                ->setLastName($userData['lastname'])
                ->setType($userData['type'])
                ->setEmail($userData['email'])
                ->setUsername($userData['username'])
                ->setPhone($userData['phone'])
            ;

            $user->setCreated(new \DateTime());
            $user->setUpdated(new \DateTime());

            $manager->persist($user);

        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
