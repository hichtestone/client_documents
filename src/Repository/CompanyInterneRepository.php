<?php

namespace App\Repository;

use App\Entity\CompanyInterne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyInterne|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyInterne|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyInterne[]    findAll()
 * @method CompanyInterne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyInterneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyInterne::class);
    }

    // /**
    //  * @return CompanyInterne[] Returns an array of CompanyInterne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompanyInterne
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
