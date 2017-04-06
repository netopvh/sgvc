<?php

namespace App\Repositories\Configuration;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Configuration\ParametrosRepository;
use App\Models\Configuration\Parametros;
use App\Validators\Configuration\ParametrosValidator;

/**
 * Class ParametrosRepositoryEloquent
 * @package namespace App\Repositories\Configuration;
 */
class ParametrosRepositoryEloquent extends BaseRepository implements ParametrosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Parametros::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
