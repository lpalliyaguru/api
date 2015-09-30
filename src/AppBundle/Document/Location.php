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
    public $x;

    /**
     * @ODM\String
     */
    public $y;

}