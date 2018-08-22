<?php

namespace App\Repository;

use App\Entity\Vehicle;
use App\Repository\TypeRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findAllScooters()
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT * FROM vehicle WHERE type_id like (SELECT id FROM type WHERE type.name like 'scooter')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    public function findOneScooterById($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT * FROM vehicle WHERE id = :id AND type_id like (SELECT id FROM type WHERE type.name like 'scooter')";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    public function getScooterType()
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT * FROM vehicle WHERE id = :id AND type_id like (SELECT id FROM type WHERE type.name like 'scooter')";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }


//    /**
//     * @return Vehicle[] Returns an array of Vehicle objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
