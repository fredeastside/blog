<?php

declare(strict_types=1);

namespace AppBundle\Post\Service\Implementation;

use AppBundle\Post\Entity\Post;
use AppBundle\Post\Form\PostDTO;
use AppBundle\Post\Repository\Posts;
use AppBundle\Post\Service\PostService as PostServiceInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PostService implements PostServiceInterface
{
    private $posts;
    private $tokenStorage;

    public function __construct(Posts $posts, TokenStorageInterface $tokenStorage)
    {
        $this->posts = $posts;
        $this->tokenStorage = $tokenStorage;
    }

    public function getAll()
    {
        return $this->posts->findAll();
    }

    public function add(PostDTO $postDTO)
    {
        $post = Post::create($postDTO);
        $post->addUser($this->getUser());
        $this->posts->save($post);
    }

    public function getDTOByPost(Post $post)
    {
        $postDTO = new PostDTO();
        $postDTO->name = $post->name();
        $postDTO->category = $post->category();
        $postDTO->content = $post->content();
        $postDTO->description = $post->description();
        $postDTO->tags = $post->tags();

        return $postDTO;
    }

    public function update(Post $post, PostDTO $postDTO)
    {
        $post->update($postDTO);
        $post->addUser($this->getUser());
        $this->posts->save($post);
    }

    public function remove(Post $post)
    {
        $this->posts->remove($post);
    }

    private function getUser()
    {
        $token = $this->tokenStorage->getToken();
        $errorMessage = 'User not auth.';

        if (empty($token)) {
            throw new \UnexpectedValueException($errorMessage);
        }

        $user = $token->getUser();

        if (empty($user)) {
            throw new \UnexpectedValueException($errorMessage);
        }

        return $user;
    }
}