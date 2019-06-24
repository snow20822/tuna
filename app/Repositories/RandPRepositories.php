<?php

namespace App\Repositories;

use App\Models\RandP;
use Auth;

class RandPRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = RandP::orderBy('RandP_term', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function allHistoryTerm($filters)
    {
        $data = RandP::orderBy('RandP_term', 'desc')
            ->orderBy('RandP_term_type', 'desc')
            ->where($filters)
            ->distinct()
            ->get(['RandP_term', 'RandP_term_type']);

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }
}