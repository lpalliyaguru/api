<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 * @ODM\Document(repositoryClass="AppBundle\Document\PostRepository")
 *
 */
class Post {
    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @var string
     *
     * @ODM\String
     */
    protected $title;

    /**
     * @var string
     *
     * @ODM\String
     */
    protected $text;

    /**
     * @var string
     *
     * @ODM\String
     */
    protected $image;

    /**
     * @var
     * @ODM\Date
     */
    protected $createdAt;

    /**
     * @var
     * @ODM\Boolean
     */
    protected $published;

    /**
     * @ODM\ReferenceOne(targetDocument="Blog\AdminBundle\Document\User", cascade="persist")
     */
    protected $createdBy;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setImagePath($path)
    {
        $this->image = $path;
    }

    public function getImagePath()
    {
        return $this->image;
    }

    public function isPublished()
    {
        return $this->published;
    }

    public function setCreatedBy($user)
    {
        $this->createdBy = $user;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}