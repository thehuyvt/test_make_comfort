<?php
if (! function_exists('checkAdmin')) {
    function checkAdmin()
    {
        return session()->get('role') === 1;
    }
}

if (! function_exists('array_filter_empty')) {
    function array_filter_empty($arr)
    {
        return array_filter($arr, function($each){
            return $each;
        });
    }
}
