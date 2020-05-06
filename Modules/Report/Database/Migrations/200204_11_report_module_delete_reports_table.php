<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteReportsTable extends Migration
{
	const DB_CONNECTION = 'psc';
	const DB_PREFIX = 'pr';
	const DB_TABLE_KEY = 'id';
	const DB_NAME_SGL = 'report';
	const DB_NAME_PLR = 'reports';
	const DB_TABLE_TRAN = '_translations';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection(self::DB_CONNECTION)->table(self::DB_NAME_PLR, function (Blueprint $table) {
			$table->dropForeign(['point_id']);
		});
		Schema::table(self::DB_PREFIX.'_'.self::DB_NAME_PLR, function (Blueprint $table) {
			$table->dropForeign(['user_id']);
		});
		Schema::connection(self::DB_CONNECTION)->dropIfExists(self::DB_NAME_SGL.self::DB_TABLE_TRAN);
		Schema::connection(self::DB_CONNECTION)->dropIfExists(self::DB_NAME_PLR);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection(self::DB_CONNECTION)->create(self::DB_NAME_PLR, function (Blueprint $table) {
			$table->bigIncrements(self::DB_TABLE_KEY);
            $table->unsignedInteger('issue_id')->nullable()->default(NULL);
#            $table->bigInteger('point_id')->unsigned()->nullable()->default(NULL);
			$table->integer('user_id')->unsigned()->nullable()->default(NULL);
			$table->boolean('published')->default(0);
			$table->timestamps();
		});

#		Schema::connection(self::DB_CONNECTION)->table(self::DB_NAME_PLR, function (Blueprint $table) {
#			$table->foreign('point_id')->references(self::DB_TABLE_KEY)->on('points')->onDelete('cascade');
#		});
		Schema::table(self::DB_PREFIX.'_'.self::DB_NAME_PLR, function (Blueprint $table) {
			$table->foreign('user_id')->references(self::DB_TABLE_KEY)->on('users')->onDelete('cascade');
		});

		$s_fkey = self::DB_NAME_SGL.'_'.self::DB_TABLE_KEY;
		Schema::connection(self::DB_CONNECTION)->create(self::DB_NAME_SGL.self::DB_TABLE_TRAN, function (Blueprint $table) use ($s_fkey) {
			$table->increments(self::DB_TABLE_KEY);
            $table->bigInteger($s_fkey)->unsigned();

			$table->string('locale')->index();
			$table->string('title')->default('')->nullable(false);
			$table->string('description')->default('')->nullable(false);

			$table->unique([$s_fkey, 'locale']);
			$table->foreign($s_fkey)->references(self::DB_TABLE_KEY)->on(self::DB_NAME_PLR)->onDelete('cascade');
		});
	}

}

