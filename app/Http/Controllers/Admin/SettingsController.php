<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = array();
        foreach (Setting::all() as $setting) {
            $settings[$setting->name] = Setting::name($setting->name);
        }

        return view('admin.settings.form', [
            'settings' => $settings,
        ]);
    }
}
