<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamBoardColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn(['team_member', 'board_member']);
        });

        Schema::table('festival_artist', function (Blueprint $table) {
            $table->boolean('team_member')->default(0);
            $table->boolean('board_member')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('festival_artist', function (Blueprint $table) {
            $table->dropColumn(['team_member', 'board_member']);
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->boolean('team_member')->default(0);
            $table->boolean('board_member')->default(0);
        });
    }
}
