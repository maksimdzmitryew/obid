<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishedColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('festivals', function (Blueprint $table) {
            $table->boolean('published')->default(1);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->boolean('published')->default(1);
        });

        Schema::table('presses', function (Blueprint $table) {
            $table->boolean('published')->default(1);
        });

        Schema::table('media', function (Blueprint $table) {
            $table->boolean('published')->default(1);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('published')->default(1);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('festivals', function (Blueprint $table) {
            if(Schema::hasColumn('festivals', 'published'))
                $table->dropColumn('published');
        });

        Schema::table('events', function (Blueprint $table) {
            if(Schema::hasColumn('events', 'published'))
                $table->dropColumn('published');
        });

        Schema::table('presses', function (Blueprint $table) {
            if(Schema::hasColumn('presses', 'published'))
                $table->dropColumn('published');
        });

        Schema::table('media', function (Blueprint $table) {
            if(Schema::hasColumn('media', 'published'))
                $table->dropColumn('published');
        });

        Schema::table('posts', function (Blueprint $table) {
            if(Schema::hasColumn('posts', 'published'))
                $table->dropColumn('published');
        });

    }
}
