<?php

namespace AppBundle\Domain\Doctrine;

use AppBundle\Domain\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * Class HashPasswordListener
 *
 * @package AppBundle\Domain\Doctrine
 */
class HashPasswordListener implements EventSubscriber
{
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * HashPasswordListener constructor.
     *
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function __construct(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }
        $this->encodePassword($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }
        $this->encodePassword($entity);
        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    private function encodePassword(User $entity)
    {
        if (!$entity->getPlainPassword()) {
            return;
        }
        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPlainPassword()
        );
        $entity->encodePassword($encoded);
    }
}