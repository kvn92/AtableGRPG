<?php

namespace App\DTO;

/**
 * DTO générique pour compter les statistiques (total, actifs, inactifs).
 */
class CountStatsDTO
{
    private int $total;
    private int $actives;
    private int $inactives;

    public function __construct(int $total, int $actives, int $inactives)
    {
        $this->total = $total;
        $this->actives = $actives;
        $this->inactives = $inactives;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getActives(): int
    {
        return $this->actives;
    }

    public function getInactives(): int
    {
        return $this->inactives;
    }
}
