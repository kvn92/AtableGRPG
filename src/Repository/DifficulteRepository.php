<?php

namespace App\Repository;

use App\DTO\CountStatsDTO;
use App\Entity\Difficulte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Difficulte>
 */
class DifficulteRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Difficulte::class);
    }


    public function getDifficulteStats(): CountStatsDTO
    {
        return $this->getStatsByStatus('c', 'statutDifficultes');
    }

 /*   public function countTotalDifficultes(): int
    {
        return $this->createQueryBuilder('c') // 'c' est l'alias de l'entité Categorie
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countDifficultesByStatus(bool $status): int
    {
        return $this->createQueryBuilder('c') // 'c' est l'alias pour l'entité Categorie
            ->select('COUNT(c.id)')
            ->where('c.statutCategories = :statut')
            ->setParameter('statut', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }*/

    //    /**
    //     * @return Difficulte[] Returns an array of Difficulte objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Difficulte
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
