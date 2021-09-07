<?php

namespace App;

use App\Setting;

class Settings
{
    public function __construct()
    {
        foreach (Setting::wherePublished(1)->get() as $setting) {
            $this->{$setting->slug} = $setting->is_translatable
                ? $setting->translated_value
                : $setting->value
            ;
        }
    }
}
