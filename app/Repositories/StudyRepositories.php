<?php

namespace App\Repositories;

use App\Models\Study;
use Auth;

class StudyRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Study::orderBy('Sch_term', 'desc')->where($filters)->get();

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
        $data = Study::orderBy('Sch_term', 'desc')
            ->orderBy('Sch_term_type', 'desc')
            ->where($filters)
            ->distinct()
            ->get(['Sch_term', 'Sch_term_type']);

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }
}