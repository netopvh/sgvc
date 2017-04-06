<?php

namespace App\Repositories\Access;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Access\Contracts\PermissionRepository;
use App\Models\Access\Permission;
use Prettus\Repository\Traits\CacheableRepository;
//use App\Validators\Access\PermissionValidator;

/**
 * Class PermissionRepositoryEloquent
 * @package namespace App\Repositories\Access;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository, CacheableInterface
{

    /**
     * Trait com os métodos do CacheableInterface
     */
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
