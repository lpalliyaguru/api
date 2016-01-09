<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use AppBundle\Document\Property;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\Document
 * @ODM\Document(repositoryClass="AppBundle\Document\Repository\UserRepository")
 * @ODM\HasLifecycleCallbacks
 *
 */
class User implements BaseUserInterface
{
    const TYPE_LANDLORD = 'LANDLORD';
    const TYPE_TENENT   = 'TENANT';

    /**
     * @ODM\Id
     *
     */
    private $id;

    /**
     * @ODM\String
     * @ODM\UniqueIndex(order="asc")
     * @Assert\NotBlank()
     *
     */
    private $username;

    /**
     * @ODM\String
     * @Assert\NotBlank(message = "First Name cannot be empty")
     */
    private $firstName;

    /**
     * @ODM\String
     * @Assert\NotBlank(message = "Last Name cannot be empty")
     */
    private $lastName;

    /**
     * @ODM\String
     * @Assert\NotBlank(message = "Email cannot be empty")
     * @Assert\Email(message = "Email Should be in valid format")
     */
    private $email;

    /**
     * @ODM\String
     * @Assert\NotBlank(message = "Type cannot be empty")
     */
    private $type;

    /**
     * @ODM\String
     */
    private $profilePic;

    /**
     * @ODM\String
     */
    private $phone;

    /**
     * @ODM\String
     * @Exclude()
     */
    private $password;

    /**
     * @Assert\NotBlank(message = "Password cannot be empty")
     * @Exclude()
     */
    private $plainPassword;

    /**
     * @ODM\Date
     */
    private $created;

    /**
     * @ODM\Date
     */
    private $updated;

    /**
     * @ODM\ReferenceMany(targetDocument="Property")
     */
    private $properties;

    /**
     * @ODM\Collection
     */
    private $roles;

    /**
     * @ODM\String
     * @Exclude()
     */
    private $salt;

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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setFirstName($fname)
    {
        $this->firstName = $fname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setLastName($lname)
    {
        $this->lastName = $lname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
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
    public function setProfilePic($profilePic)
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getProfilePic()
    {
        return $this->profilePic;
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

    /**
     * Set Password
     *
     * @param string $email
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get Password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $email
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get Plain password
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set plain passoword
     *
     * @param string $email
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get Properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set Properties
     *
     * @param array $properties
     * @return User
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        if($this->created == null) {
            $this->created = new \DateTime(null);
        }
    }

    /**
     * @ODM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime(null);
    }

    public function getRoles ()
    {
        return array();
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function eraseCredentials()
    {

    }
}
