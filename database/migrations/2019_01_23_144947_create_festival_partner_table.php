<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFestivalPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function(Blueprint $table){
            $table->dropForeign('partners_festival_id_foreign');
            $table->dropColumn('festival_id');
        });

        Schema::create('festival_partner', function (Blueprint $table) {
            $table->integer('partner_id')->unsigned();
            $table->integer('festival_id')->unsigned();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('festival_id')->references('id')->on('festivals')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('festival_partner', function(Blueprint $table){
//            $table->dropForeign('festival_partner_partner_id_foreign');
//            $table->dropForeign('festival_partner_festival_id_foreign');
//        });

        Schema::dropIfExists('festival_partner');

        Schema::table('partners', function(Blueprint $table){
            //$table->unsignedInteger('festival_id')->unsigned()->nullable();
        });
    }
}
