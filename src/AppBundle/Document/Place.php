<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use AppBundle\Entity\Organisation;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;

/**
 * @ODM\Document
 * @ODM\Document(repositoryClass="AppBundle\Document\Repository\PlaceRepository")
 *
 */
class Place
{
    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\String
     */
    private $name;

    /**
     * @ODM\String
     */
    private $type;

    /**
     * @ODM\String
     */
    private $address;

    /**
     * @ODM\String
     */
    private $zip;

    /**
     * @ODM\EmbedOne(targetDocument="Location")
     */
    protected $location;

    /**
     * @ODM\EmbedOne(targetDocument="Meta")
     */
    protected $__meta;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Meta data
     *
     * @param Meta $meta
     * @return Place
     */
    public function setMeta($meta)
    {
        $this->__meta = $meta;

        return $this;
    }

    /**
     * Get Meta data
     *
     * @param Meta $meta
     * @return Meta
     */
    public function getMeta()
    {
        return $this->__meta;
    }

}
