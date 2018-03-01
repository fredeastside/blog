<?php

namespace App\User\Registration\Handler;

use App\Common\Handler\Handler;
use App\User\Entity\User;
use App\User\Registration\Command\UserActivation as Command;
use App\User\Repository\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserActivation implements Handler
{
    private $users;
    private $em;

    public function __construct(Users $users, EntityManagerInterface $em)
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
