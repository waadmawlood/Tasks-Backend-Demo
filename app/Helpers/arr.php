<?php

use Illuminate\Support\Collection;

if (!function_exists('array_filter_values')) {

    /**
     * filter values of array
     *
     * @param array|Collection|null $arr
     * @param Closure|null $callback
     * @return null|array
     */
    function array_filter_values(array|Collection|null $arr, Closure|null $callback = null)
    {
        if (blank($arr))
            return null;

        if ($arr instanceof Collection)
            $arr = $arr->toArray();

        return array_values(array_filter($arr, $callback));
    }
}
