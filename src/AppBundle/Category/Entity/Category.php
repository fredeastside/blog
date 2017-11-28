<?php

namespace AppBundle\Category\Entity;

use AppBundle\Common\Entity\Sluggable;
use AppBundle\Common\Entity\Implementation\Sluggable as SluggableTrait;
use AppBundle\Common\Entity\Timestampable;
use AppBundle\Common\Entity\Implementation\Timestampable as TimestampableTrait;
use AppBundle\Post\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\{
    Entity,
    Table,
    Id,
    GeneratedValue,
    Column,
    OneToMany
};

/**
 * @Entity()
 * @Table(name="categories")
 */
class Category implements Timestampable, Sluggable
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
     * @Column(type="string")
     */
    private $picture;

    /**
     * @OneToMany(targetEntity="AppBundle\Post\Entity\Post", mappedBy="category")
     */
    private $posts;

    public function __construct(string $name, string $picture)
    {
        $this->posts = new ArrayCollection();
        $this->name = $name;
        $this->picture = $picture;
    }

    public function id()
    {
        return $this->id;
    }

    public function picture()
    {
        return $this->picture;
    }

    public function addPost(Post $post)
    {
        if ($this->posts->contains($post)) {
            return;
        }

        $this->posts->add($post);
    }
}