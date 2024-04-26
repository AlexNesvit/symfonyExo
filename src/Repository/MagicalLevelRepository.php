<?php

namespace App\Repository;

use App\Entity\MagicalLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MagicalLevel>
 *
 * @method MagicalLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method MagicalLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method MagicalLevel[]    findAll()
 * @method MagicalLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MagicalLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MagicalLevel::class);
    }

    //    /**
    //     * @return MagicalLevel[] Returns an array of MagicalLevel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MagicalLevel
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
