<?php

namespace App\Repository;

use App\Entity\Penalty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Penalty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Penalty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Penalty[]    findAll()
 * @method Penalty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PenaltyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Penalty::class);
    }

//    /**
//     * @return Penalty[] Returns an array of Penalty objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Penalty
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
