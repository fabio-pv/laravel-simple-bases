<?php

if (!function_exists('from_to_data')) {
    function from_to_data(string $param = '')
    {
        return config('from_to_data.' . $param);
    }
}
