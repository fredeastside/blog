<?php

namespace App\Post\Entity;

use App\Category\Entity\Category;
use App\Common\Entity\Sluggable;
use App\Common\Entity\Implementation\Sluggable as SluggableTrait;
use App\Common\Entity\Timestampable;
use App\Common\Entity\Implementation\Timestampable as TimestampableTrait;
use App\Common\Event\DomainEvents;
use App\Common\Event\DomainEventsPublisher;
use App\Post\Form\PostDTO;
use App\Tag\Entity\Tag;
use App\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
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
class Post implements Timestampable, Sluggable, DomainEventsPublisher
{
    use TimestampableTrait;
    use SluggableTrait;
    use DomainEvents;

    /**
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="App\User\Entity\User", inversedBy="posts")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="App\Category\Entity\Category", inversedBy="posts")
     * @var Category $category
     */
    private $category;

    /**
     * @ManyToMany(targetEntity="App\Tag\Entity\Tag", mappedBy="posts", orphanRemoval=true)
     */
    private $tags;

    /**
     * @Column(type="text")
     */
    private $description;

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

    public static function create(PostDTO $postDTO)
    {
        $post = new self();
        $post->update($postDTO);

        return $post;
    }

    public function update(PostDTO $postDTO)
    {
        $this->name = $postDTO->name;
        $this->updateContent($postDTO->content);
        $this->description = $postDTO->description;
        $this->addTags($postDTO->tags);
        $this->addCategory($postDTO->category);
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

    public function getCategoryName()
    {
        return $this->category->name();
    }

    public function description()
    {
        return $this->description;
    }

    public function updateContent(string $newContent)
    {
        if ($this->content === $newContent) {
            return;
        }

        $this->content = $newContent;
    }
}