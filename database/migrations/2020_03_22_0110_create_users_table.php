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
			$table->boolean('enabled')								->default(0)	->nullable(false);
			$table->string('email')						->unique()					->nullable(false);
			$table->string('password')												->nullable(false);
			$table->string('title')													->nullable(false);
			$table->string('first_name')											->nullable(false);
			$table->string('last_name')												->nullable(false);
			$table->rememberToken()													->nullable(false);
			$table->string('activation_token', 40)									->nullable(false);
			$table->timestamps();
		});
		DB::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION)->insert(
			array(
				'id'			=> 1,
				'enabled'		=> 1,
				'title'			=> 'der Entwickler',
				'email'			=> 'max@efte.in',
				'password'		=> '$2y$10$QTRATLSIt.BwdTeuWUx.VOycyqPEWUEvaah3jI18LWcUjs26auxKu',
				'first_name'	=> 'Max',
				'last_name'		=> 'D',
				'created_at'	=> '2020-03-22 01:10:00',
				'updated_at'	=> '2020-03-22 01:10:00',
			)
		);
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
