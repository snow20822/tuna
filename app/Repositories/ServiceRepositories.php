<?php

namespace App\Repositories;

use App\Models\Service;
use Auth;

class ServiceRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Service::orderBy('Sch_term', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['info'] = false;
            }

            return $result;
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function allHistoryTerm($filters)
    {
        $data = Service::orderBy('Sch_term', 'desc')
            ->orderBy('Sch_term_type', 'desc')
            ->where($filters)
            ->distinct()
            ->get(['Sch_term', 'Sch_term_type']);

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }
}