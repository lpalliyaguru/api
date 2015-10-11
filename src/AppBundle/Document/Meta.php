<?php

namespace AppBundle\Document;

/**
 * Class Location
 * @ODM\EmbeddedDocument
 * @package AppBundle\Document
 */
class Meta
{
    /**
     * @ODM\Date
     */
    public $created;

    /**
     * @ODM\Date
     */
    public $updated;
}
