<?php

namespace App\Repository;

use App\Entity\BlogEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BlogEntryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogEntry::class);
    }

    public function findAllCreatedToday()
    {
        $qb = $this->createQueryBuilder('b')
            ->andWhere('b.created = :today')
            ->setParameter('today',new \DateTime('today'))
            ->getQuery();
        return $qb->execute();

    }
}
