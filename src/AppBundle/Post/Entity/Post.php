<?php

namespace AppBundle\Post\Entity;

use AppBundle\Category\Entity\Category;
use AppBundle\Common\Entity\Sluggable;
use AppBundle\Common\Entity\Implementation\Sluggable as SluggableTrait;
use AppBundle\Common\Entity\Timestampable;
use AppBundle\Common\Entity\Implementation\Timestampable as TimestampableTrait;
use AppBundle\Post\Add\Command\AddPost;
use AppBundle\Tag\Entity\Tag;
use AppBundle\User\Entity\User;
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

    private function __construct()
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

    public static function create(AddPost $addPost)
    {
        $post = new self();
        $post->name = $addPost->name;
        $post->content = $addPost->content;
        $post->addTags($addPost->tags);
        $post->addCategory($addPost->category);

        return $post;
    }

    public function addUser(User $user)
    {
        $this->user = $user;
        $this->user->addPost($this);
    }

    private function addTags(iterable $tags)
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    private function addTag(Tag $tag)
    {
        if ($this->tags->contains($tag)) {
            return;
        }

        $tag->addPost($this);
        $this->tags->add($tag);
    }

    private function addCategory(Category $category)
    {
        $this->category = $category;
        $category->addPost($this);
    }
}