<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

# Laravel has traits to roll-back changes made to the database. 
# In 5.6, it's the RefreshDatabase trait
# in some earlier versions it was DatabaseTransactions instead.

use Illuminate\Foundation\Testing\RefreshDatabase;
#use Illuminate\Foundation\Testing\DatabaseMigrations;
#use Illuminate\Foundation\Testing\WithoutMiddleware;

trait CreatesApplication
{

    use RefreshDatabase;
#    use DatabaseMigrations;
#    use WithoutMiddleware;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
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
