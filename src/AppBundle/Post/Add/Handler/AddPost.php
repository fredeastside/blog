<?php

namespace AppBundle\Post\Add\Handler;

use AppBundle\Common\Handler\Handler;
use AppBundle\Post\Entity\Post;
use AppBundle\Post\Repository\Posts;
use AppBundle\Post\Add\Command\AddPost as AddPostCommand;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddPost implements Handler
{
    private $posts;
    private $tokenStorage;

    public function __construct(Posts $posts, TokenStorageInterface $tokenStorage)
    {
        $this->posts = $posts;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param AddPostCommand $command
     */
    public function handle($command)
    {
        $post = Post::create($command);
        $post->addUser($this->getUser());
        $this->posts->save($post);
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