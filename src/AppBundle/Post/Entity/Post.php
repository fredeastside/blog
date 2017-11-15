<?php

namespace AppBundle\Post\Entity;

use AppBundle\Common\Entity\Sluggable;
use AppBundle\Common\Entity\Implementation\Sluggable as SluggableTrait;
use AppBundle\Common\Entity\Timestampable;
use AppBundle\Common\Entity\Implementation\Timestampable as TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\{
    Entity,
    Table,
    Id,
    GeneratedValue,
    Column,
    ManyToOne,
    ManyToMany
};

/**
 * @Entity()
 * @Table(name="posts")
 */
class Post implements Timestampable, Sluggable
{
    use TimestampableTrait;
    use SluggableTrait;

    /**
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="AppBundle\User\Entity\User", inversedBy="posts")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="AppBundle\Category\Entity\Category", inversedBy="posts")
     */
    private $category;

    /**
     * @ManyToMany(targetEntity="AppBundle\Tag\Entity\Tag", mappedBy="posts", orphanRemoval=true)
     */
    private $tags;

    /**
     * @Column(type="text")
     */
    private $content;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function id()
    {
        return $this->id;
    }

    public function user()
    {
        return $this->user;
    }

    public function category()
    {
        return $this->category;
    }

    public function tags()
    {
        return $this->tags;
    }

    public function content()
    {
        return $this->content;
    }
}