<?php

namespace AppBundle\Common\EventListener\Doctrine;

use AppBundle\Common\Event\DomainEventsPublisher;
use AppBundle\Common\Event\EventDispatcher;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostFlushEventArgs;

class DomainEventsSubscriber implements EventSubscriber
{
    private $eventDispatcher;
    /** @var DomainEventsPublisher[] */
    private $entities = [];

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
            Events::postFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        $this->addInReleaseEventsItems($uow->getScheduledEntityInsertions());
        $this->addInReleaseEventsItems($uow->getScheduledEntityUpdates());
        $this->addInReleaseEventsItems($uow->getScheduledEntityDeletions());
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        foreach ($this->entities as $entity) {
            $this->eventDispatcher->dispatch($entity->releaseEvents());
        }
    }

    private function addInReleaseEventsItems($entities)
    {
        foreach ($entities as $entity) {
            if (!$entity instanceof DomainEventsPublisher) {
                continue;
            }
            $this->entities[] = $entity;
        }
    }
}
