<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTranslationsTable extends Migration
{
    const TABLE_MIGRATION = 'translations';
    const TABLE_HASONE = 'countries';
    const HASONE_TABLE = 'country';
    const HASONE_KEY = 'id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::HASONE_TABLE.'_'.self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments(self::HASONE_KEY);
            $table->unsignedInteger(self::HASONE_TABLE.'_'.self::HASONE_KEY);
            $table->string('locale')->index();
            $table->string('name');

            $table->unique([self::HASONE_TABLE.'_'.self::HASONE_KEY, 'locale', 'name']);
            $table->foreign(self::HASONE_TABLE.'_'.self::HASONE_KEY)->references(self::HASONE_KEY)->on(self::TABLE_HASONE)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::HASONE_TABLE.'_'.self::TABLE_MIGRATION);
    }
}
