<?php

namespace App\Repositories\Application\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EmpresaRepository
 * @package namespace App\Repositories;
 */
interface EmpresaRepository extends RepositoryInterface
{
    public function getAll($columns = ['*']);
    public function searchPaginate($field, $value, $columns = ['*']);
    public function findEmpresa($id);
}
