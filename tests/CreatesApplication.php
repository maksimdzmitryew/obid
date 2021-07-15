<?php

declare(strict_types=1);

namespace Tests;

use                Illuminate\Contracts\Console\Kernel;

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

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication() : \Illuminate\Foundation\Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        if ($app->environment() != 'testing')
        {   
           echo "\n-----\n".$app->environment()."\n-----\n";
        }
        return $app;
    }
}
