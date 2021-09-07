<?php

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'psc';
    const TABLE_MIGRATION       = 'password_resets';

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::connection($this->getConnection())->create($this->getTable(), function (Blueprint $table) {
            $table->string('email')                         ->default('')->nullable(false)->index()     ->comment('userʼs email who requested password reset');
            $table->string('token', 40)                     ->default('')->nullable(false)              ->comment('token to identify user authenticity');
            $table->timestamp('created_at')                                                             ->comment('time when token was sent to check against token expiration');
            $table->index(['token', 'email'], $this->getTable('sg') . '_user_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->getConnection())->dropIfExists($this->getTable());
    }
}
