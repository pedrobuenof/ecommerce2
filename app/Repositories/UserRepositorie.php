<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositorieInterface;

class UserRepositorie extends BaseRepository implements UserRepositorieInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

}
