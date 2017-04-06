<?php
/**
 * Created by PhpStorm.
 * User: angelo.neto
 * Date: 03/04/2017
 * Time: 10:33
 */

namespace App\Repositories\Application\Contracts;


use Prettus\Repository\Contracts\RepositoryInterface;

interface ContratoAditivoRepository extends RepositoryInterface
{

    public function findAltFilename(array $attributes);

}