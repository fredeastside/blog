<?php

declare(strict_types=1);

namespace AppBundle\Post\EventListener;

use AppBundle\Post\Entity\Post;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkdownToHTMLSubscriber implements EventSubscriber
{
    private $parser;

    public function __construct(MarkdownParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->changeMarkdownToHTML($args);
        /*$entity = $args->getEntity();
        $em   = $args->getEntityManager();
        $uow  = $em->getUnitOfWork();
        $meta = $em->getClassMetadata(get_class($entity));
        $uow->recomputeSingleEntityChangeSet($meta, $entity);*/
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->changeMarkdownToHTML($args);
    }

    public function changeMarkdownToHTML(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Post) {
            return;
        }

        $html = $this->parser->transformMarkdown($entity->content());
        $entity->updateContent($html);
    }
}