<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\CountStatsDTO;

/**
 * Repository de base pour ajouter des statistiques sans perdre les méthodes natives.
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * Méthode générique pour récupérer les statistiques (total, actif, inactif).
     */
    public function getStatsByStatus(string $entityAlias, string $statusField): CountStatsDTO
    {
        $qb = $this->createQueryBuilder($entityAlias);

        // Compter le total des enregistrements
        $total = (clone $qb)
            ->select("COUNT($entityAlias.id)")
            ->getQuery()
            ->getSingleScalarResult();

        // Compter les enregistrements actifs
        $actives = (clone $qb)
            ->select("COUNT($entityAlias.id)")
            ->where("$entityAlias.$statusField = :status")
            ->setParameter('status', true)
            ->getQuery()
            ->getSingleScalarResult();

        // Compter les enregistrements inactifs
        $inactives = (clone $qb)
            ->select("COUNT($entityAlias.id)")
            ->where("$entityAlias.$statusField = :status")
            ->setParameter('status', false)
            ->getQuery()
            ->getSingleScalarResult();

        return new CountStatsDTO($total, $actives, $inactives);
    }
}
