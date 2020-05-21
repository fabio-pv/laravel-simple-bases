<?php

if (!function_exists('get_name_previous_function')) {
    function get_name_previous_function()
    {
        return debug_backtrace()[1]['function'];
    }
}
