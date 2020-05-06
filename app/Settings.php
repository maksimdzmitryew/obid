<?php

namespace App;

use App\Setting;

class Settings
{
    public function __construct()
    {
        foreach (Setting::all() as $setting) {
            $this->{$setting->name} = $setting->is_translatable ?
                $setting->translated_value :
                $setting->value;
        }
    }
}