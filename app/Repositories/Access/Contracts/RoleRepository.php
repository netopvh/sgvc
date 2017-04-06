<?php

namespace App\Repositories\Access\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RoleRepository
 * @package namespace App\Repositories\Access;
 */
interface RoleRepository extends RepositoryInterface
{
    public function getCount();
    public function findRole($id);
}
