<?php

namespace App\Infrastructure\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Model\CompetencePersonnage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;

/**
 * @extends ServiceEntityRepository<CompetencePersonnage>
 *
 * @method CompetencePersonnage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetencePersonnage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetencePersonnage[]    findAll()
 * @method CompetencePersonnage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetencePersonnageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetencePersonnage::class);
    }

    //    /**
    //     * @return CompetencePersonnage[] Returns an array of CompetencePersonnage objects
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

    //    public function findOneBySomeField($value): ?CompetencePersonnage
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
