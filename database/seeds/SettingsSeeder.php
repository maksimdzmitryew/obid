<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings', 'setting_translation')->delete();

        factory(App\Setting::class)->create([
            'name' => 'domain',
            'value' => 'http://culturescapes.ch'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'established',
            'value' => '2003'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'facebook',
            'value' => 'culturescapes'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'youtube',
            'value' => 'user/baselCULTURESCAPES'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'instagram',
            'value' => 'culturescapes.ch'
        ]);


        factory(App\Setting::class)->create([
            'name' => 'title',
            'value' => 'project title',
            'is_translatable' => 1,
            'en' => [
                'translated_value' => 'CULTURESCAPES'
            ],
            'de' => [
                'translated_value' => 'CULTURESCAPES'
            ]
        ]);
    }
}
