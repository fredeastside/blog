<?php

namespace AppBundle\User\Registration\Handler;

use AppBundle\User\Entity\User;
use AppBundle\User\Registration\Command\UserActivation as Command;
use AppBundle\User\Repository\Users;
use Doctrine\ORM\EntityManager;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserActivation implements MessageBus
{
    private $users;
    /**
     * @var EntityManager $em
     */
    private $em;

    public function __construct(Users $users)
    {
        $this->users = $users;
        $this->em = $this->users->getManager();
    }

    public function handle($activation)
    {
        $this->disableDoctrineActiveFilter();
        $user = $this->getUser($activation->activationCode());
        $user->activate();
        $this->em->flush();
    }

    private function disableDoctrineActiveFilter(): void
    {
        $this->em->getFilters()->disable('select_only_active');
    }

    private function getUser($activationCode): User
    {
        /** @var User $user */
        $user = $this->users->findByActivationCode($activationCode);
        if (empty($user)) {
            throw new NotFoundHttpException();
        }

        return $user;
    }
}
