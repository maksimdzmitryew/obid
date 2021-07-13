<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	const DB_CONNECTION		= 'psc';
	const TABLE_MIGRATION	= 'users';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection(self::DB_CONNECTION)->create(self::TABLE_MIGRATION, function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('enabled')										->default(0)->nullable(false)->comment('account is enabled and user will be allowed to sign in');
			$table->string('email')						->unique()							->nullable(false);
			$table->string('password')																->nullable(false);
			$table->string('title')																		->nullable(false);
			$table->string('first_name')															->nullable(false);
			$table->string('last_name')																->nullable(false);
			$table->rememberToken()																		->nullable(false);
			$table->string('activation_token', 40)										->nullable(false);
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
