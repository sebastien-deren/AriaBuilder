<?php

namespace App\PersonnageCreator\Infrastucture\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\PersonnageCreator\Domain\Model\Profession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\PersonnageCreator\Domain\Repository\ProfessionRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Profession>
 *
 * @method Profession|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profession|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profession[]    findAll()
 * @method Profession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineProfessionRepository extends ServiceEntityRepository implements ProfessionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profession::class);
    }

    public function getOne(int $id): ?Profession
    {
        return $this->find($id);
    }
    /**
     * @return Profession
     */
    public function getAll(): array
    {
        $pagination = (new Paginator($this->findBy([])));
    }
    //    /**
    //     * @return Profession[] Returns an array of Profession objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Profession
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
