<?php

namespace AppBundle\User\Entity;

use AppBundle\Common\Entity\Timestampable;
use AppBundle\Common\Entity\Implementation\Timestampable as TimestampableTrait;
use AppBundle\Common\Event\DomainEvents;
use AppBundle\User\Registration\Command\UserRegistration;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\{
    Entity,
    Table,
    Id,
    GeneratedValue,
    Column,
    OneToMany
};

/**
 * @Entity()
 * @Table(name="users")
 */
class User implements UserInterface, Timestampable
{
    use TimestampableTrait;
    use DomainEvents;

    /**
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /**
     * @Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @Column(type="string", unique=true)
     */
    private $email;

    /**
     * @Column(type="json_array")
     */
    private $roles = [];

    /**
     * @Column(type="string")
     */
    private $password;

    private $plainPassword;

    /**
     * @OneToMany(targetEntity="AppBundle\Post\Entity\Post", mappedBy="user", cascade={"remove"})
     */
    private $posts;

    private function __construct(string $email, string $password)
    {
        $this->posts = new ArrayCollection();
        $this->email = $email;
        $this->plainPassword = $password;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function encodePassword(string $hash)
    {
        $this->password = $hash;

        return $this;
    }

    public static function createFromRegistration(UserRegistration $registration)
    {
        $user = new self($registration->email, $registration->plainPassword);
        $user->toAuth();

        return $user;
    }

    public function toAdmin()
    {
        $this->addRole(Role::ROLE_ADMIN);
    }

    private function toAuth()
    {
        $this->addRole(Role::ROLE_USER);
    }

    private function addRole(string $role)
    {
        if (!$this->hasRole($role)) {
            array_push($this->roles, $role);
        }

        return $this;
    }

    private function removeRole(string $role)
    {
        if ($this->hasRole($role)) {
            $key = array_search($role, $this->roles, true);
            if ($key !== false) {
                unset($this->roles[$key]);
            }
        }

        return $this;
    }

    private function hasRole(string $role)
    {
        return in_array($role, $this->roles, true);
    }
}
