<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation\Exclude;

use AppBundle\Document\Location;
use AppBundle\Document\User;
use AppBundle\Document\Preferred;

/**
 * @ODM\Document
 * @ODM\Document(repositoryClass="AppBundle\Document\Repository\PropertyRepository")
 *
 */
class Property
{
    /**
     * @Exclude
     */
    static $types = array(
        'HDB' => 'HDB',
        'LND' => 'Landed House',
        'CND' => 'Condo'
    );
    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\String
     */
    protected $name;

    /**
     * @ODM\String
     */
    protected $address;

    /**
     * @ODM\String
     */
    protected $description;
    /**
     * @ODM\String
     */
    protected $zip;

    /**
     * @ODM\EmbedOne(targetDocument="Location")
     */
    protected $location;

    /**
     * @ODM\String
     */
    protected $tags;

    /**
     * @ODM\ReferenceOne(targetDocument="User")
     */
    protected $owner;

    /**
     * @ODM\String
     */
    protected $type;

    /**
     * @ODM\EmbedOne(targetDocument="PropertyAsset")
     */
    protected $asset;

    /**
     * @ODM\String
     */
    protected $price;

    /**
     * @ODM\String
     */
    protected $pricePSF;

    /**
     * @ODM\Float
     */
    protected $floorArea;

    /**
     * @ODM\String
     */
    protected $tenure;

    /**
     * @ODM\String
     */
    protected $condition;

    /**
     * @ODM\String
     */
    protected $leaseTerm;

    /**
     * @ODM\Collection
     */
    protected $special;

    /**
     * @ODM\Int
     */
    protected $bedRooms;

    /**
     * @ODM\Int
     */
    protected $bathRooms;

    /**
     * @ODM\Boolean
     */
    protected $smoking;

    /**
     * @ODM\Boolean
     */
    protected $published;

    /**
     * @ODM\EmbedOne(targetDocument="Preferred")
     */
    protected $preferred;

    /**
     * @ODM\EmbedOne(targetDocument="Meta")
     */
    protected $__meta;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setAsset($asset)
    {
        $this->asset = $asset;
        return $this;
    }

    public function getAsset()
    {
        return $this->asset;
    }

    public function setPricePSF($pricePSF)
    {
        $this->pricePSF = $pricePSF;
        return $this;
    }

    public function getPricePSF()
    {
        return $this->pricePSF;
    }

    public function setFloorArea($area)
    {
        $this->floorArea = $area;
        return $this;
    }

    public function getFloorArea()
    {
        return $this->floorArea;
    }

    public function setTenure($tenure)
    {
        $this->tenure = $tenure;
        return $this;
    }

    public function getTenure()
    {
        return $this->tenure;
    }

    public function setCondition($condition)
    {
        $this->condition = $condition;
        return $this;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function setLeaseTerm($term)
    {
        $this->leaseTerm = $term;
        return $this;
    }

    public function getLeaseTerm()
    {
        return $this->leaseTerm;
    }

    public function setSpecial($special)
    {
        $this->special = $special;
        return $this;
    }

    public function getSpecial()
    {
        return $this->special;
    }

    public function setBedrooms($bedRooms)
    {
        $this->bedRooms = $bedRooms;
        return $this;
    }

    public function getBedrooms()
    {
        return $this->bedRooms;
    }

    public function setSmoking($smoking)
    {
        $this->smoking = $smoking;
        return $this;
    }

    public function getSmoking()
    {
        return $this->smoking;
    }

    public function setBathrooms($bathRooms)
    {
        $this->bathRooms = $bathRooms;
        return $this;
    }

    public function getBathrooms()
    {
        return $this->bathRooms;
    }

    public function setPreferred($preferred)
    {
        $this->preferred = $preferred;
        return $this;
    }

    public function getPreferred()
    {
        return $this->preferred;
    }

    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setMeta($meta)
    {
        $this->__meta = $meta;
        return $this;
    }

    public function setPublished($flag)
    {
        $this->published = $flag;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function getMeta()
    {
        return $this->__meta;
    }
}