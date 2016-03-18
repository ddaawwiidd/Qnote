<?php

namespace QnoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quote
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Quote
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="quoteBody", type="text")
     */
    private $quoteBody;

    /**
     * @var string
     *
     * @ORM\Column(name="quoteAuthor", type="string", length=100)
     */
    private $quoteAuthor;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="quotes")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quoteBody
     *
     * @param string $quoteBody
     * @return Quote
     */
    public function setQuoteBody($quoteBody)
    {
        $this->quoteBody = $quoteBody;

        return $this;
    }

    /**
     * Get quoteBody
     *
     * @return string 
     */
    public function getQuoteBody()
    {
        return $this->quoteBody;
    }

    /**
     * Set quoteAuthor
     *
     * @param string $quoteAuthor
     * @return Quote
     */
    public function setQuoteAuthor($quoteAuthor)
    {
        $this->quoteAuthor = $quoteAuthor;

        return $this;
    }

    /**
     * Get quoteAuthor
     *
     * @return string 
     */
    public function getQuoteAuthor()
    {
        return $this->quoteAuthor;
    }

    /**
     * Set userId
     *
     * @param \QnoteBundle\Entity\User $userId
     * @return Quote
     */
    public function setUserId(\QnoteBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \QnoteBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
