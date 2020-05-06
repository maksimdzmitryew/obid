<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveQtyUnique extends Migration {

    const DB_CONNECTION = 'psc';
    const TABLE_MIGRATION = 'marks';
    const KEY_MIGRATION = 'qty';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function (Blueprint $table) {
			$table->dropUnique([self::KEY_MIGRATION]);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function(Blueprint $table)
        {
            $table->unique(self::KEY_MIGRATION);
        });
	}

}

