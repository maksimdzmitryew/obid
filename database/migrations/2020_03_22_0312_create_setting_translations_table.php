<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreateSettingTranslationsTable extends Migration
{
	const DB_CONNECTION		= 'psc';
    const TABLE_MIGRATION	= 'setting_translations';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('setting_id');
            $table->char('locale',2)				->index()						->nullable(false);
            $table->text('translated_value')										->nullable(false);
            $table->unique(['setting_id', 'locale']);
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
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
