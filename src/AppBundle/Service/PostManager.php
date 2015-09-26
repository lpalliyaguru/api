<?php

namespace AppBundle\Service;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

use AppBundle\Document\Post;
use AppBundle\Service\ManagerBase;

class PostManager extends ManagerBase
{
    protected $documentManager;
    protected $repository;
    private $security;

    public function __construct(ManagerRegistry $registryManager, $security)
    {
        $this->documentManager  = $registryManager->getManager();
        $this->repository       = $registryManager->getRepository('AppBundle:Post');
        $this->security         = $security;
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

    public function savePost($formData)
    {
        $post = new Post();

        $post->setTitle($formData['title']);
        $post->setText($formData['content']);
        $post->setCreatedBy(null);
        $this->persistAndFlush($post);
        return true;
    }
}