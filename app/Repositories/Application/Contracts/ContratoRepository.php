<?php

namespace App\Repositories\Application\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ContratoRepository
 * @package namespace App\Repositories;
 */
interface ContratoRepository extends RepositoryInterface
{
    public function getAllWithRelations($columns = ['*']);
    public function getAllByVencimento($columns = ['*']);
    public function searchWithRelations(array $attributes, $columns = ['*']);
    public function searchForAdditions(array $attributes, $columns = ['*']);
    public function createNormal(array $attributes);
    public function viewContrato($id);
    public function excelExport();
    public function findContrato($id);
    public function findGestores($id);
    public function findFiscais($id);
    public function findEmpresas($id);

}
