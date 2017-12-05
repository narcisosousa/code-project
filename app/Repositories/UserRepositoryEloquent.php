<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\UserRepository;
use CodeProject\Entities\User;
use CodeProject\Validators\UserValidator;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
