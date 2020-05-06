<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnIdLengthPlacetranslationsTable extends Migration {

    const DB_CONNECTION = 'psc';
    const DB_TABLE_KEY = 'id';
    const DB_NAME_SGL = 'place';
    const DB_NAME_PLR = 'places';
    const DB_TABLE_TRAN = '_translations';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection(self::DB_CONNECTION)->table(self::DB_NAME_SGL.self::DB_TABLE_TRAN, function (Blueprint $table) {
            $table->bigIncrements(self::DB_TABLE_KEY)->change();
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::connection(self::DB_CONNECTION)->table(self::DB_NAME_SGL.self::DB_TABLE_TRAN, function (Blueprint $table) {
            $table->increments(self::DB_TABLE_KEY)->change();
        });
	}

}
