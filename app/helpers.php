<?php

use Morilog\Jalali\CalendarUtils;

if (! function_exists('fa')) {

    function fa($value)
    {
        return CalendarUtils::convertNumbers($value);
    }

}