<?php
/**
 * Created by PhpStorm.
 * User: M.LASANTHA
 * Date: 9/18/2015
 * Time: 11:22 AM
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;

class CommentManager
{

    private $em;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository('AppBundle:Comment');

    }

    public function getOneById($id)
    {
        return $this->repository->find($id);
    }


}