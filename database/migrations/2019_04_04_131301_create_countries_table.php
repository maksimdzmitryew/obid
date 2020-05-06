<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    const TABLE_MIGRATION = 'countries';
    const KEY_MIGRATION = 'id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments(self::KEY_MIGRATION);
            $table->string('iso', 2)->default('');
            $table->boolean('published')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_MIGRATION);
    }
}
