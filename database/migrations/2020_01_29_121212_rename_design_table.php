<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDesignTable extends Migration
{
	const DB_CONNECTION = 'psc';
	const TABLE_FROM = 'design';
	const TABLE_TO = 'element';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection(self::DB_CONNECTION)->rename(self::TABLE_FROM.'s', self::TABLE_TO.'s');
		Schema::connection(self::DB_CONNECTION)->rename(self::TABLE_FROM.'_translations', self::TABLE_TO.'_translations');
		Schema::connection(self::DB_CONNECTION)->table(self::TABLE_TO.'_translations', function (Blueprint $table) {
			$table->renameColumn(self::TABLE_FROM.'_id', self::TABLE_TO.'_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection(self::DB_CONNECTION)->table(self::TABLE_TO.'_translations', function (Blueprint $table) {
			$table->renameColumn(self::TABLE_TO.'_id', self::TABLE_FROM.'_id');
		});
		Schema::connection(self::DB_CONNECTION)->rename(self::TABLE_TO.'_translations', self::TABLE_FROM.'_translations');
		Schema::connection(self::DB_CONNECTION)->rename(self::TABLE_TO.'s', self::TABLE_FROM.'s');
	}

}
