<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpinionsTable extends Migration {

    const DB_CONNECTION = 'psc';
	const DB_PREFIX = 'pr';
    const DB_TABLE_KEY = 'id';
    const DB_NAME_SGL = 'opinion';
    const DB_NAME_PLR = 'opinions';
    const DB_TABLE_TRAN = '_translations';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection(self::DB_CONNECTION)->create(self::DB_NAME_PLR, function (Blueprint $table) {
            $table->bigIncrements(self::DB_TABLE_KEY);

#			$table->integer('element_id')->unsigned()->nullable()->default(NULL);
#			$table->integer('mark_id')->unsigned()->nullable()->default(NULL);
            $table->bigInteger('place_id')->unsigned()->nullable()->default(NULL);
			$table->integer('user_id')->unsigned()->nullable()->default(NULL);

            $table->boolean('published')->default(0);
            $table->timestamps();
        });
/*
		Schema::connection(self::DB_CONNECTION)->table(self::DB_NAME_PLR, function (Blueprint $table) {
			$table->foreign('element_id')->references(self::DB_TABLE_KEY)->on('elements')->onDelete('cascade');
		});
		Schema::connection(self::DB_CONNECTION)->table(self::DB_NAME_PLR, function (Blueprint $table) {
			$table->foreign('mark_id')->references(self::DB_TABLE_KEY)->on('marks')->onDelete('cascade');
		});
*/
		Schema::connection(self::DB_CONNECTION)->table(self::DB_NAME_PLR, function (Blueprint $table) {
			$table->foreign('place_id')->references(self::DB_TABLE_KEY)->on('places')->onDelete('cascade');
		});
/*
		Schema::table(self::DB_PREFIX.'_'.self::DB_NAME_PLR, function (Blueprint $table) {
			$table->foreign('user_id')->references(self::DB_TABLE_KEY)->on('users')->onDelete('cascade');
		});
*/
		$s_fkey = self::DB_NAME_SGL.'_'.self::DB_TABLE_KEY;
        Schema::connection(self::DB_CONNECTION)->create(self::DB_NAME_SGL.self::DB_TABLE_TRAN, function (Blueprint $table) use ($s_fkey) {
            $table->bigIncrements(self::DB_TABLE_KEY);
            $table->bigInteger($s_fkey)->unsigned();
            $table->string('locale')->index();
            $table->string('title')->default('')->nullable(false);
            $table->string('description')->default('')->nullable(false);

            $table->unique([$s_fkey, 'locale']);
            $table->foreign($s_fkey)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR)->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::connection(self::DB_CONNECTION)->dropIfExists(self::DB_NAME_SGL.self::DB_TABLE_TRAN);
        Schema::connection(self::DB_CONNECTION)->dropIfExists(self::DB_NAME_PLR);
	}

}

