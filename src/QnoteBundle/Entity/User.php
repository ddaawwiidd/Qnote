<?php
// src/QnoteBundle/Entity/User.php

namespace QnoteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Quote", mappedBy="userId")
     */
    protected $quotes;



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add quotes
     *
     * @param \QnoteBundle\Entity\Quote $quotes
     * @return User
     */
    public function addQuote(\QnoteBundle\Entity\Quote $quotes)
    {
        $this->quotes[] = $quotes;

        return $this;
    }

    /**
     * Remove quotes
     *
     * @param \QnoteBundle\Entity\Quote $quotes
     */
    public function removeQuote(\QnoteBundle\Entity\Quote $quotes)
    {
        $this->quotes->removeElement($quotes);
    }

    /**
     * Get quotes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuotes()
    {
        return $this->quotes;
    }
}
