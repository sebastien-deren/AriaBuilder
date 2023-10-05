<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Entity\CompetenceProfession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompetenceProfession>
 *
 * @method CompetenceProfession|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetenceProfession|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetenceProfession[]    findAll()
 * @method CompetenceProfession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceProfessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetenceProfession::class);
    }

    //    /**
    //     * @return CompetenceProfession[] Returns an array of CompetenceProfession objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CompetenceProfession
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
