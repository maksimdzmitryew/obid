<?php

namespace App\Traits;

trait GeneralTrait
{
    public static function getTimestampDates()
    {
        $dates['min_created_at'] = static::min('created_at');
        $dates['max_created_at'] = static::max('created_at');
        $dates['null_created_at'] = static::whereNull('created_at')->count();
        $dates['min_updated_at'] = static::min('updated_at');
        $dates['max_updated_at'] = static::max('updated_at');
        $dates['null_updated_at'] = static::whereNull('updated_at')->count();

        return $dates;
    }
}
