<?php
namespace QnoteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class QuoteRepository extends EntityRepository
{
   /* public function findByUser(User $user)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT quote FROM QnoteBundle:Quote quote JOIN quote.fos_user id')
    }
}