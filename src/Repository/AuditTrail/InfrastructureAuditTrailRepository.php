<?php

namespace App\Repository\AuditTrail;

use App\Entity\AuditTrail\InfrastructureAuditTrail;
use App\Repository\AuditTrailTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfrastructureAuditTrail|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfrastructureAuditTrail|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfrastructureAuditTrail[]    findAll()
 * @method InfrastructureAuditTrail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfrastructureAuditTrailRepository extends ServiceEntityRepository
{
    use AuditTrailTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfrastructureAuditTrail::class);
    }

    // /**
    //  * @return InfrastructureAuditTrail[] Returns an array of InfrastructureAuditTrail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfrastructureAuditTrail
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
