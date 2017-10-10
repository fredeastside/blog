<?php

namespace AppBundle\User\Entity;

use AppBundle\Domain\DataTransferObject\UserRegistration;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\{
    Entity,
    Table,
    Index,
    Id,
    GeneratedValue,
    Column
};
use Gedmo\Mapping\Annotation\Timestampable;

/**
 * @Entity()
 * @Table(name="user", indexes={ @Index(name="idx_email", columns={"email"}) })
 */
class User implements UserInterface
{
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
     * @Timestampable(on="create")
     * @Column(type="datetime")
     */
    private $created;

    /**
     * @Timestampable(on="update")
     * @Column(type="datetime")
     */
    private $updated;

    /**
     * User constructor.
     *
     * @param string $email
     * @param string $password
     */
    private function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->plainPassword = $password;
    }

    /**
     *
     */
    public function getSalt()
    {
    }

    /**
     *
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = Role::ROLE_USER;

        return array_unique($roles);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $hash
     *
     * @return $this
     */
    public function encodePassword(string $hash)
    {
        $this->password = $hash;

        return $this;
    }

    /**
     * @param UserRegistration $registration
     *
     * @return User
     */
    public static function register(UserRegistration $registration)
    {
        return new self($registration->email, $registration->plainPassword);
    }
}
