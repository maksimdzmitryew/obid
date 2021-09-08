<?php

declare(strict_types=1);

namespace Tests;

use                                             DB;
use                Illuminate\Contracts\Console\Kernel;
use               Illuminate\Foundation\Testing\RefreshDatabaseState;
# Laravel has traits to roll-back changes made to the database. 
# In 5.6, it's the RefreshDatabase trait
# in some earlier versions it was DatabaseTransactions instead.

/**
 * DB usage variants
 *
 * DatabaseTransactions trait
 *
 * before running tests database needs to be migrated
 * From my experience this is the best option if you have a lot of tests and you care about speed and/or run many single tests
 *
 *
 * RefreshDatabase trait
 *
 * kind of replaces DatabaseMigrations and DatabaseTransactions
 * in-memory database: it will run php artisan migrate for you
 * not in-memory database: it will drop all your tables and do a fresh run of php artisan migrate
 * this is also quite quick however at the beginning it automatically migrates database. In case you often run single tests and you care about performance this could not be solution for you. However for running full tests suite this is very good option
 *
 *
 * DatabaseMigrations trait
 *
 * triggers php artisan migrate command and before the application is destroyed, it rolls everything back.
 * this is the worse choice in my opinion. Migrations are applied before each test and then they are rolled back after each test so the speed of tests is not very impressive.
 */

use               Illuminate\Foundation\Testing\RefreshDatabase;
#use Illuminate\Foundation\Testing\DatabaseMigrations;
#use Illuminate\Foundation\Testing\DatabaseTransactions;
#use               Illuminate\Foundation\Testing\WithoutMiddleware;

trait CreatesApplication
{
    use RefreshDatabase;
#    use DatabaseMigrations;
#    use DatabaseTransactions;
#    use WithoutMiddleware;

    private static function _getTablesWithoutPrefixes() : array
    {
        $a_prefixes_raw = config('database.connections');
        $a_prefixes = [];
        $i_prefix_len = 0;
        foreach ($a_prefixes_raw AS $a_prefix)
        {
            $a_prefixes[] = $a_prefix['prefix'];
            $i_tmp = strlen($a_prefix['prefix']);
            $i_prefix_len = ($i_prefix_len < $i_tmp ? $i_tmp : $i_prefix_len);
        }

        $b_migration_updated = false;
        $a_tables_raw = DB::table('INFORMATION_SCHEMA.TABLES')->get();
        $a_tables = [];

        foreach ($a_tables_raw AS $o_table)
        {
            $s_name = $o_table->TABLE_NAME;
            $s_tmp = $o_table->TABLE_NAME;
            /**
             *  capitalized are "native" tables
             *  ignore them
             */
            if ($s_tmp != strtoupper($s_tmp))
            {
                /**
                 *  remove prefix from the beginning of the table name
                 */
                $s_tmp = str_replace($a_prefixes, '', substr($s_tmp, 0, $i_prefix_len))
                /**
                 *  add the remaining table name to the end
                 */
                        . substr($s_tmp, $i_prefix_len)
                    ;
                $a_tables[$s_tmp] = strtotime($o_table->CREATE_TIME);
            }
        }
        return $a_tables;
    }

    private static function _getTablesFromMigrationsTitles() : array
    {
        chdir('database/migrations');
        $a_files = glob('*');

        $a_tables = [];

        foreach ($a_files AS $s_file)
        {
            $a_file = explode('.', $s_file);
            $a_name = explode('create_', $s_file);
            if(isset($a_name[1]))
            {
                $a_name = explode('_table', $a_name[1]);
 #               dump($a_name);
#                dump( filemtime($s_file) . ' ' . date('c',filemtime($s_file)) . ' ' . $s_file);
                $s_table = $a_name[0];
                $a_tables[$s_table] = filemtime($s_file);
            }
        }
        return $a_tables;
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication() : \Illuminate\Foundation\Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        /**
         *  each test triggers this Trait and function
         *  for the first run let's check if we have any updates to any migration
         */
        if (!RefreshDatabaseState::$migrated)
        {
            $b_already_migrated = true;
            $a_tables = self::_getTablesWithoutPrefixes();
            $a_migrations = self::_getTablesFromMigrationsTitles();
            /**
             * check if migration is needed
             */
            foreach ($a_migrations AS $s_table => $i_timestamp)
            {
                /**
                 *  there is a migration but table does not exist
                 */
                $b_already_migrated = $b_already_migrated && isset($a_tables[$s_table]);
                /**
                 *  there was a update made to migration later than table was created from its execution
                 */
                $b_already_migrated = $b_already_migrated && ($a_migrations[$s_table] - $a_tables[$s_table] < 0);
            }
            RefreshDatabaseState::$migrated = $b_already_migrated;
        }

        if ($app->environment() != 'testing')
        {   
           echo "\n-----\n".$app->environment()."\n-----\n";
        }
        return $app;
    }
}
