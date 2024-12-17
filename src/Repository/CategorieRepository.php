<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\DTO\CountStatsDTO;
use Doctrine\Persistence\ManagerRegistry;

class CategorieRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * Méthode pour récupérer les statistiques spécifiques aux catégories.
     */
    public function getCategorieStats(): CountStatsDTO
    {
        return $this->getStatsByStatus('c', 'statutCategories');
    }
}
