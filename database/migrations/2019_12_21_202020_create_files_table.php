<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
	const DB_CONNECTION = 'usu';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fileable_id')->unsigned()->nullable()->index();
            $table->string('fileable_type')->nullable()->index();
			$table->boolean('published')->default(1);
            $table->tinyInteger('position')->unsigned()->nullable();
            $table->integer('size')->unsigned()->default(0)->nullable(false);
            $table->string('type')->default('')->nullable(false);
            $table->string('title')->default('')->nullable(false);
            $table->string('copyright')->default('')->nullable(false);
            $table->string('alt')->default('')->nullable(false);
            $table->string('savedname')->default('')->nullable(false);
            $table->string('url')->default('')->nullable(false);
            $table->string('url_medium')->default('')->nullable(false);
            $table->string('url_small')->default('')->nullable(false);
            $table->string('path')->default('')->nullable(false);
            $table->string('path_medium')->default('')->nullable(false);
            $table->string('path_small')->default('')->nullable(false);
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
        Schema::connection(self::DB_CONNECTION)->dropIfExists('files');
    }
}
