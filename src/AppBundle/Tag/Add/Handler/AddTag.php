<?php

namespace AppBundle\Tag\Add\Handler;

use AppBundle\Common\Handler\Handler;
use AppBundle\Tag\Add\Command\AddTag as AddTagCommand;
use AppBundle\Tag\Entity\Tag;
use AppBundle\Tag\Repository\Tags;

class AddTag implements Handler
{
    private $tags;

    public function __construct(Tags $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param AddTagCommand $command
     */
    public function handle($command)
    {
        $tag = new Tag($command->name);
        $this->tags->save($tag);
    }
}