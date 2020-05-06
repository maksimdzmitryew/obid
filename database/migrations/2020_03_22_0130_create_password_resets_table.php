<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
	const DB_CONNECTION		= 'psc';
	const TABLE_MIGRATION	= 'password_resets';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection(self::DB_CONNECTION)->create(self::DB_CONNECTION, function (Blueprint $table) {
			$table->string('email')						->index()					->nullable(false);
			$table->string('token', 40)												->nullable(false);
			$table->timestamp('created_at')											->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection(self::DB_CONNECTION)->dropIfExists(self::DB_CONNECTION);
	}
}
