<?php

declare(strict_types=1);

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingDatabaseSeeder extends Seeder
{
    private static function _fillData(Array $a_main, Array $a_extra) : void
    {
        factory(\Modules\Setting\Database\Setting::class)->create(array_merge($a_main, $a_extra));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        /**
         *  create array with empty L10N data
         *  to override faker's default values
         */
        $a_langs = config('translatable.languages');
        $a_data_no_translation = ['is_translatable' => 0,];
        foreach ($a_langs AS $s_lang => $s_country)
        {
            $a_data_no_translation[$s_lang] = [ ];
        }


        /**
         *  data to be filled in as default and/or test values
         */

        self::_fillData(
            [
                'slug' => 'domain',
                'value' => 'https://efte.in',
            ],
            $a_data_no_translation
        );

        self::_fillData(
            [
                'slug' => 'theme',
                'value' => 'obedyV1',
            ],
            $a_data_no_translation
        );

        self::_fillData(
            [
                'slug' => 'established',
                'value' => '2020',
            ],
            $a_data_no_translation
        );

        self::_fillData(
            [
                'slug' => 'email',
                'value' => 'info@efte.in',
            ],
            $a_data_no_translation
        );

        self::_fillData(
            [
                'slug' => 'facebook',
                'value' => 'eftein',
            ],
            $a_data_no_translation
        );

        self::_fillData(
            [
                'slug' => 'youtube',
                'value' => 'user/eftein',
            ],
            $a_data_no_translation
        );

        self::_fillData(
            [
                'slug' => 'instagram',
                'value' => 'eftein',
            ],
            $a_data_no_translation
        );

        $a_data_tmp = $a_data_no_translation;
        $a_data_tmp['is_translatable'] = 1;
        $a_data_tmp['uk'] =
        [
            'title' => 'project title',
            'translated_value' => 'efte.in',
        ];
        self::_fillData(
            [
                'slug' => 'title',
                'value' => '',
            ],
            $a_data_tmp
        );

    }
}
