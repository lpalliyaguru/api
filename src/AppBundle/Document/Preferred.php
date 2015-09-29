<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Preferred
 * @ODM\EmbeddedDocument
 * @package AppBundle\Document
 */
class Preferred
{
    /**
     * @ODM\String
     */
    public $gender;

    /**
     * @ODM\String
     */
    public $nationality;

}