<?php

namespace App\Repository;

use App\Entity\SubNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubNote>
 *
 * @method SubNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubNote[]    findAll()
 * @method SubNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubNote::class);
    }

    //    /**
    //     * @return SubNote[] Returns an array of SubNote objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SubNote
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
