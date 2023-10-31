<?php

namespace App\Repository\AuditTrail;

use App\Entity\AuditTrail\EquipementAuditTrail;
use App\Repository\AuditTrailTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EquipementAuditTrail|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipementAuditTrail|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipementAuditTrail[]    findAll()
 * @method EquipementAuditTrail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipementAuditTrailRepository extends ServiceEntityRepository
{
    use AuditTrailTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipementAuditTrail::class);
    }

    // /**
    //  * @return EquipementAuditTrail[] Returns an array of EquipementAuditTrail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EquipementAuditTrail
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
