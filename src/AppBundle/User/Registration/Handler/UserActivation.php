<?php

namespace AppBundle\User\Registration\Handler;

use AppBundle\Common\Handler\Handler;
use AppBundle\User\Entity\User;
use AppBundle\User\Registration\Command\UserActivation as Command;
use AppBundle\User\Repository\Users;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserActivation implements Handler
{
    private $users;
    private $em;

    public function __construct(Users $users, EntityManager $em)
    {
        $this->users = $users;
        $this->em = $em;
    }

    /**
     * @param Command $activation
     */
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
