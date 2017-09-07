<?php

namespace Yannick\CrudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="utilisateurs")
 * @ORM\Entity(repositoryClass="Yannick\CrudBundle\Repository\UsersRepository")
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, unique=true)
     */
    private $email;


    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Yannick\CrudBundle\Entity\Departements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $RefDep;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }




    /**
     * Set refDepId
     *
     * @param \Yannick\CrudBundle\Entity\Departements $refDepId
     *
     * @return Users
     */
    public function setRefDep(\Yannick\CrudBundle\Entity\Departements $refDep)
    {
        $this->RefDep = $refDep;

        return $this;
    }

    /**
     * Get refDepId
     *
     * @return \Yannick\CrudBundle\Entity\Departements
     */
    public function getRefDep()
    {
        return $this->RefDep;
    }
}
