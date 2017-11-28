<?php

namespace AppBundle\Post\Add\Handler;

use AppBundle\Common\Handler\Handler;
use AppBundle\Post\Entity\Post;
use AppBundle\Post\Repository\Posts;
use AppBundle\Post\Add\Command\AddPost as AddPostCommand;

class AddPost implements Handler
{
    private $posts;

    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @param AddPostCommand $command
     */
    public function handle($command)
    {
        //$command->user = $user;
        $post = Post::create($command);
        $this->posts->save($post);
    }
}