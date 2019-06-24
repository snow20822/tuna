<?php

if (! function_exists('addParamInUrl')) {

    /**
     * add param
     *
     * @param array $needAdd
     * @return
     */
    function addParamInUrl($to, $needAdd)
    {
        $question = Request::getBaseUrl().Request::getPathInfo() == '/' ? '/?' : '?';

        return count(Request::query()) > 0
            ? $to.$question.http_build_query(array_merge(Request::query(), $needAdd))
            : $to.$question.http_build_query($needAdd);
    }
}

if (! function_exists('getTermRound')) {

    /**
     * 取得學期 (detault get 10)
     *
     * @return
     */
    function getTermRound($total = 10)
    {
        $base = 1911;
        $year = date('Y');

        $termNow = $year - $base;
        $end = $termNow - $total;

        return range($termNow, $end);
    }
}