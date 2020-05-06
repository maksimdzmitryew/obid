<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextsTable extends Migration
{
    const TABLE_MIGRATION = 'texts';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments('id');
            $table->string('codename')->unique();
            $table->timestamps();
        });
        DB::table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 1,
                'codename'      => 'footer_contacts',
                'created_at'    => '2019-03-02 21:21:21',
                'updated_at'    => '2019-03-02 21:21:21',
            )
        );        
        DB::table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 2,
                'codename'      => 'footer_about',
                'created_at'    => '2019-03-03 17:17:17',
                'updated_at'    => '2019-03-03 17:17:17',
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
        Schema::dropIfExists(self::TABLE_MIGRATION);
    }
}
