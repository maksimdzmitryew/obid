<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishedAtColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dateTime('published_at')->default(Carbon::now())->nullable();
        });

        Schema::table('presses', function (Blueprint $table) {
            $table->dateTime('published_at')->default(Carbon::now())->nullable();
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dateTime('published_at')->default(Carbon::now())->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });

        Schema::table('presses', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
}
