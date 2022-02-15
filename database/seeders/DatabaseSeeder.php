<?php

declare(strict_types=1);

namespace Database\Seeders;

use                                             DB;
use                Illuminate\Database\Eloquent\Model as BaseModel;
use                                         App\Model;
use               Illuminate\Foundation\Testing\RefreshDatabaseState;
use                         Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate =
    [
        'role'                  => true,
        'user'                  => true,
    ];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        echo "\n";
        foreach($this->toTruncate as $s_table_name => $b_seed) 
        {
#            $s_model_main = Model::getModelNameWithNamespace($s_table_name);
#            $s_model_seed = Model::seedTableMainAndTranslation($s_model_main);

            #if ($b_seed && !RefreshDatabaseState::$migrated)
            {
                Model::seedTable($s_table_name);
                echo '|' . 'seeded: ' . $s_table_name . '|' . "\n";
#                $s_table_name = $this->getTable('sg');
#                Model::getModelSeederWithNamespace($s_model_main, $s_model_seed, false);
            }
        }
    }
}
