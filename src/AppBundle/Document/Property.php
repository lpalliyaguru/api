<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 * @ODM\Document(repositoryClass="AppBundle\Document\PropertyRepository")
 *
 */
class Property
{
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
    protected $zip;

    /**
     * @EmbedOne(targetDocument="Location")
     */
    protected $location;

    /**
     * @ODM\String
     */
    protected $tags;

    /**
     * @ReferenceOne(targetDocument="User")
     */
    protected $owner;

    /**
     * @ODM\String
     */
    protected $type;

    /**
     * @ODM\Collection
     */
    protected $images;

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
     * @EmbedOne(targetDocument="Preferred")
     */
    protected $preferred;

    /**
     * @ODM\Date
     */
    protected $created;

    /**
     * @ODM\Date
     */
    protected $updated;

}