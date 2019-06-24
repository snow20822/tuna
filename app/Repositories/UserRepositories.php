<?php

namespace App\Repositories;

use App\Models\Users;

class UserRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        return Users::where($filters)->first()->toArray();
    }
}