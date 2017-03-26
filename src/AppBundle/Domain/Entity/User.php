<?php

namespace AppBundle\Domain\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @package AppBundle\Domain\Entity
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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
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

    /**
     * @Assert\NotBlank()
     */
    private $plainPassword;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     */
    public function getSalt()
    {

    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->email;
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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        $this->password = null;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
