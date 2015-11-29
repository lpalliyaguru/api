<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Location
 * @ODM\EmbeddedDocument
 * @package AppBundle\Document
 */
class Location
{
    /**
     * @ODM\String
     */
    public $type;

    /**
     * @ODM\Collection
     */
    public $coordinates = array();

    public function __construct()
    {
        $this->type = 'Point';
    }

    public function cleanCoords()
    {
        $this->coordinates[0] = floatval($this->coordinates[0]);
        $this->coordinates[1] = floatval($this->coordinates[1]);
    }
}
