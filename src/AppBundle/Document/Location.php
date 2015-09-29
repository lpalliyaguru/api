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
    public $x;

    public $y;

}