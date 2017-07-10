<?php

namespace AppBundle\Domain\Entity;

use AppBundle\Domain\DataTransferObject\UserRegistration;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="AppBundle\Domain\Repository\UserRepository")
 * @ORM\Table(name="user", indexes={ @ORM\Index(name="idx_email", columns={"email"}) })
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    private $plainPassword;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * User constructor.
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
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
