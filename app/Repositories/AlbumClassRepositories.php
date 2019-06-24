<?php

namespace App\Repositories;

use App\Models\AlbumClass;

class AlbumClassRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = AlbumClass::orderBy('Id', 'asc')->where($filters)->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }

    /**
     * get all class
     *
     * @param array
     */
    public static function getAll()
    {
        $data = AlbumClass::orderBy('Id', 'asc')->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }
}