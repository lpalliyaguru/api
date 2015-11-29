<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * Class Location
 * @ODM\EmbeddedDocument
 * @package AppBundle\Document
 */
class PropertyAsset
{
    /**
     * @ODM\String
     */
    protected $coverImage;

    /**
     * @ODM\Collection
     */
    protected $images;

    public function getCoverImage()
    {
        return $this->coverImage;

    }

    public function setCoverImage($image)
    {
        $this->coverImage = $image;
    }

    public function getImages()
    {
        return $this->images;

    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function addImage($image)
    {
        $this->images[] = $image;
    }
}