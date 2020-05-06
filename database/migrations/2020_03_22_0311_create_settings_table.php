<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
	const DB_CONNECTION		= 'psc';
    const TABLE_MIGRATION	= 'settings';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments('id');
			$table->boolean('enabled')								->default(0)	->nullable(false);
            $table->string('name')						->unique()					->nullable(false);
            $table->string('value')													->nullable(false);
            $table->boolean('is_translatable')							->default(0)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(self::DB_CONNECTION)->dropIfExists(self::TABLE_MIGRATION);
    }
}
