<?php

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'psc';
    const TABLE_MIGRATION       = 'countries';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->getConnection())->create($this->getTable(), function (Blueprint $table) {
            $this->addPrimaryKey($this, $table);

            $table->char('iso', 2)                          ->default('')->nullable(false)->index() ->comment('ISO 3166-1 alpha-2 country code');
            $table->boolean('published')                    ->default(0)->nullable(false)->index()  ->comment('item is confirmed and available to users');
            $table->timestamps();
        });
        $this->upTranslationMigration();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->downTranslationMigration();
        Schema::connection($this->getConnection())->dropIfExists($this->getTable());
    }
}
