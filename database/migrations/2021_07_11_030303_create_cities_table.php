<?php

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'psc';
    const TABLE_MIGRATION       = 'cities';

    protected static $o_country = '';

    public function __construct()
    {
        self::$o_country        = new CreateCountriesTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->getConnection())->create($this->getTable(), function (Blueprint $table) {
            $this->addPrimaryKey($this, $table);
            $this->addForeignKey(self::$o_country, $table);

            $table->string('timezone');
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
