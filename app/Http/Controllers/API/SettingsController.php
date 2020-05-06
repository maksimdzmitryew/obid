<?php

namespace App\Http\Controllers\API;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function update(Request $request)
    {
        foreach ($request->settings as $setting_name => $value) {
            $setting = Setting::name($setting_name);

            $setting->is_translatable ?
                $setting->update([
                    'en' =>  [
                        'translated_value' => $value['en'],
                    ],
                    'de' =>  [
                        'translated_value' => $value['de'],
                    ],
                ]) :
                $setting->update(['value' => $value]);
        }

        return response([], 200);
    }
}
