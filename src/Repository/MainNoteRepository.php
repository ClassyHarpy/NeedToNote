<?php

namespace App\Repository;

use App\Entity\MainNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MainNote>
 *
 * @method MainNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainNote[]    findAll()
 * @method MainNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainNote::class);
    }

    //    /**
    //     * @return MainNote[] Returns an array of MainNote objects
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

    //    public function findOneBySomeField($value): ?MainNote
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
