<?php

namespace App\Repositories\Access\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository
 * @package namespace App\Repositories\Access;
 */
interface UserRepository extends RepositoryInterface
{
   public function getAllWithRoles();
   public function findUser($id);
}

