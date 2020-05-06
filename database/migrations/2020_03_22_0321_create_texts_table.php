<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreateTextsTable extends Migration
{
	const DB_CONNECTION		= 'psc';
    const TABLE_MIGRATION	= 'texts';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments('id');
			$table->boolean('enabled')								->default(1)	->nullable(false);
            $table->string('codename')					->unique()					->nullable(false);
            $table->timestamps();
        });
        DB::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 1,
                'codename'      => 'footer_contacts',
                'created_at'    => '2019-03-02 21:21:21',
                'updated_at'    => '2019-03-02 21:21:21',
            )
        );
        DB::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION)->insert(
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
        Schema::connection(self::DB_CONNECTION)->dropIfExists(self::TABLE_MIGRATION);
    }
}
