<?php

namespace App\Tag\Entity;

use App\Common\Entity\Sluggable;
use App\Common\Entity\Implementation\Sluggable as SluggableTrait;
use App\Post\Entity\Post;
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
     * @ManyToMany(targetEntity="App\Post\Entity\Post", inversedBy="tags")
     * @JoinTable(name="posts_tags")
     */
    private $posts;

    public function __construct(string $name)
    {
        $this->posts = new ArrayCollection();
        $this->update($name);
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

    public function update($name)
    {
        $this->name = $name;
    }
}