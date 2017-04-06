<?php

namespace App\Repositories\Application\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UnidadeRepository
 * @package namespace App\Repositories;
 */
interface UnidadeRepository extends RepositoryInterface
{
    public function findUnidade($id);
}
