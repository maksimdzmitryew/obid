<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpinionVotesTable extends Migration {

    const DB_CONNECTION = 'psc';
	const DB_PREFIX = 'pr';
    const DB_TABLE_NAME = 'opinion_votes';
    const DB_TABLE_KEY = 'id';
    const DB_NAME_SGL1 = 'element';
    const DB_NAME_SGL2 = 'mark';
    const DB_NAME_SGL3 = 'opinion';
    const DB_NAME_SGL4 = 'place';
    const DB_NAME_SGL5 = 'user';
    const DB_NAME_PLR1 = 'elements';
    const DB_NAME_PLR2 = 'marks';
    const DB_NAME_PLR3 = 'opinions';
    const DB_NAME_PLR4 = 'places';
    const DB_NAME_PLR5 = 'users';

    const TABLE_HASONE = 'users';
    const HASONE_TABLE = 'user';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$s_tname	= self::DB_TABLE_NAME;
		$s_tkey1	= self::DB_NAME_SGL1.'_'.self::DB_TABLE_KEY;
		$s_tkey2	= self::DB_NAME_SGL2.'_'.self::DB_TABLE_KEY;
		$s_tkey3	= self::DB_NAME_SGL3.'_'.self::DB_TABLE_KEY;
		$s_tkey4	= self::DB_NAME_SGL4.'_'.self::DB_TABLE_KEY;
		$s_tkey5	= self::DB_NAME_SGL5.'_'.self::DB_TABLE_KEY;
        Schema::connection(self::DB_CONNECTION)->create($s_tname, function (Blueprint $table) use ($s_tname, $s_tkey1, $s_tkey2, $s_tkey3, $s_tkey4, $s_tkey5) {
            $table->integer($s_tkey1)->unsigned();
            $table->integer($s_tkey2)->unsigned();
            $table->bigInteger($s_tkey3)->unsigned();
            $table->bigInteger($s_tkey4)->unsigned();

            $table->foreign($s_tkey1)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR1)->onDelete('cascade');
            $table->foreign($s_tkey2)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR2)->onDelete('cascade');
            $table->foreign($s_tkey3)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR3)->onDelete('cascade');
            $table->foreign($s_tkey4)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR4)->onDelete('cascade');
        });

        Schema::connection(self::DB_CONNECTION)->table($s_tname, function (Blueprint $table) {
            $table->integer(self::HASONE_TABLE.'_'.self::DB_TABLE_KEY)->unsigned()->nullable()->default(NULL);
        });

        Schema::connection(self::DB_CONNECTION)->table($s_tname, function (Blueprint $table) use ($s_tname, $s_tkey1, $s_tkey2, $s_tkey3, $s_tkey4, $s_tkey5) {
            $table->primary([$s_tkey1, $s_tkey4, $s_tkey5]);
        });

        Schema::table(self::DB_PREFIX.'_'.$s_tname, function (Blueprint $table) {
            $table->foreign(self::HASONE_TABLE.'_'.self::DB_TABLE_KEY)->references(self::DB_TABLE_KEY)->on(self::TABLE_HASONE)->onDelete('cascade');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$s_tname	= self::DB_TABLE_NAME;
        Schema::connection(self::DB_CONNECTION)->dropIfExists($s_tname);
	}

}
