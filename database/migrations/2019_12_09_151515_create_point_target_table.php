<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointTargetTable extends Migration {

    const DB_CONNECTION = 'psc';
    const DB_TABLE_KEY = 'id';
    const DB_NAME_SGL1 = 'point';
    const DB_NAME_SGL2 = 'target';
    const DB_NAME_PLR1 = 'points';
    const DB_NAME_PLR2 = 'targets';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$s_tname	= self::DB_NAME_SGL1.'_'.self::DB_NAME_SGL2;
		$s_tkey1	= self::DB_NAME_SGL1.'_'.self::DB_TABLE_KEY;
		$s_tkey2	= self::DB_NAME_SGL2.'_'.self::DB_TABLE_KEY;
        Schema::connection(self::DB_CONNECTION)->create($s_tname, function (Blueprint $table) use ($s_tname, $s_tkey1, $s_tkey2) {
            $table->bigInteger($s_tkey1)->unsigned();
            $table->unsignedInteger($s_tkey2);

            $table->primary([$s_tkey1, $s_tkey2]);
            $table->foreign($s_tkey1)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR1)->onDelete('cascade');
            $table->foreign($s_tkey2)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR2)->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$s_tname	= self::DB_NAME_SGL1.'_'.self::DB_NAME_SGL2;
        Schema::connection(self::DB_CONNECTION)->dropIfExists($s_tname);
	}

}
