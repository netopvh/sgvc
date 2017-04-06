<?php

namespace App\Repositories\Application\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CasaRepository
 * @package namespace App\Repositories;
 */
interface CasaRepository extends RepositoryInterface
{
    public function findCasa($id);
}
