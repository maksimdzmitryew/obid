<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // default value for existing records
        Schema::table('presses', function (Blueprint $table) {
            $table->integer('city_tmp')->unsigned()->nullable()->default(39)->after('category_id');
            $table->integer('city_id')->unsigned()->nullable()->after('category_id');
        });

        // copy default compatibility default values
        Schema::table('presses', function (Blueprint $table) {
            DB::statement('UPDATE presses SET city_id = city_tmp');
        });

        // remove column with default values
        Schema::table('presses', function (Blueprint $table) {
            $table->dropColumn('city_tmp');
        });

        Schema::table('presses', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presses', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
}
