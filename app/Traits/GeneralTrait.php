<?php

namespace App\Traits;

trait GeneralTrait
{
    public static function getTimestampDates()
    {
        $dates['min_created_at'] = static::min('created_at');
        $dates['max_created_at'] = static::max('created_at');
        $dates['min_updated_at'] = static::min('updated_at');
        $dates['max_updated_at'] = static::max('updated_at');

        return $dates;
    }
}