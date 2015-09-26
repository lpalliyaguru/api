<?php
/**
 * Created by PhpStorm.
 * User: M.LASANTHA
 * Date: 9/14/2015
 * Time: 9:32 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation\Until;
/**
 *
 * @ORM\Table("comments")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CommentRepository")
 */

class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @Type("DateTime")
     * @Since("1.2.0")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Type("DateTime")
     * @Until("2.1.3")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

}