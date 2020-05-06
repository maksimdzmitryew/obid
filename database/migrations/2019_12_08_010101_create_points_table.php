<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration {

    const DB_CONNECTION = 'psc';
    const DB_TABLE_KEY = 'id';
    const DB_NAME_SGL = 'point';
    const DB_NAME_PLR = 'points';
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
            $table->unsignedInteger('design_id')->nullable();
            $table->boolean('published')->default(0)->index();
            $table->decimal('lat', 9, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('set null');
        });
		$s_fkey = self::DB_NAME_SGL.'_'.self::DB_TABLE_KEY;
        Schema::connection(self::DB_CONNECTION)->create(self::DB_NAME_SGL.self::DB_TABLE_TRAN, function (Blueprint $table) use ($s_fkey) {
            $table->increments(self::DB_TABLE_KEY);
            $table->bigInteger($s_fkey)->unsigned();
            $table->string('locale')->index();
            $table->string('title')->default('')->nullable(false);
            $table->string('annotation')->default('')->nullable(false);
            $table->string('description')->default('')->nullable(false);
            $table->string('address')->default('')->nullable(false);

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
