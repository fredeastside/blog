<?php

namespace AppBundle\Tag\Entity;

use AppBundle\Common\Entity\Sluggable;
use AppBundle\Common\Entity\Implementation\Sluggable as SluggableTrait;
use AppBundle\Post\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\{
    Entity,
    Table,
    Id,
    GeneratedValue,
    Column,
    ManyToMany,
    JoinTable
};

/**
 * @Entity()
 * @Table(name="tags")
 */
class Tag implements Sluggable
{
    use SluggableTrait;

    /**
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /**
     * @ManyToMany(targetEntity="AppBundle\Post\Entity\Post", inversedBy="tags")
     * @JoinTable(name="posts_tags")
     */
    private $posts;

    public function __construct(string $name)
    {
        $this->posts = new ArrayCollection();
        $this->name = $name;
    }

    public function id()
    {
        return $this->id;
    }

    public function posts()
    {
        return $this->posts;
    }

    public function addPost(Post $post)
    {
        if ($this->posts->contains($post)) {
            return;
        }

        $this->posts->add($post);
    }
}