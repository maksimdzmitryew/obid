<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate =
    [
        'country_translations'      => false,
        'countries'                 => true,
    ];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        # ---- truncate
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach($this->toTruncate as $s_table_name => $b_seed) 
        {
            DB::table($s_table_name)->truncate();
            if ($b_seed)
            {
                $s_class_name = ucfirst($s_table_name).'Seeder';
                $this->call($s_class_name);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
        # ---- /truncate

        //$this->call(GeneralSeeder::class);
        //$this->call(SettingsSeeder::class);
    }
}
