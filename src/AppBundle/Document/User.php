<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use AppBundle\Entity\Organisation;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;

/**
 * @ODM\Document
 * @ODM\Document(repositoryClass="AppBundle\Document\UserRepository")
 *
 */
class User
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
    private $email;

    /**
     * @ODM\String
     */
    private $type;

    /**
     * @ODM\String
     */
    private $profile_pic;

    /**
     * @ODM\String
     */
    private $phone;

    /**
     * @ODM\Date
     */
    private $created;

    /**
     * @ODM\Date
     */
    private $updated;

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
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setProfilePicture($profilePic)
    {
        $this->profile_pic = $profilePic;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profile_pic;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

}
