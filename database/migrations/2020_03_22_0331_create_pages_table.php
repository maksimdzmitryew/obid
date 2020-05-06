<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
	const DB_CONNECTION		= 'psc';
    const TABLE_MIGRATION	= 'pages';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->index();
            $table->boolean('published')->default(1);
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
        Schema::connection(self::DB_CONNECTION)->dropIfExists(self::TABLE_MIGRATION);
    }
}
