<?php

use           Illuminate\Database\Schema\Blueprint;
use       Illuminate\Database\Migrations\Migration;
use           Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
#    const DB_CONNECTION         = 'psc';
    const DB_CONNECTION         = 'mysql';
    const TABLE_MIGRATION       = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->getConnection())->create($this->getTable(), function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enabled')                    ->default(0)->nullable(false)->index()->comment('account is enabled and user will be allowed to sign in');
            $table->string('email')           ->unique()              ->nullable(false)->index();
            $table->string('password')                                ->nullable(false);
            $table->string('title')                                   ->nullable(false);
            $table->string('first_name')                              ->nullable(false)->index();
            $table->string('last_name')                               ->nullable(false);
            $table->rememberToken()                                   ->nullable(false)->index();
            $table->string('activation_token', 40)                    ->nullable(false)->index();
            //TODO change to ULID
            //https://laravel.ru/posts/1125
            $table->uuid('uuid')                                      ->nullable(false)->index();
            /**
             * https://dev.mysql.com/doc/refman/8.0/en/multiple-column-indexes.html
             *
             * As an alternative to a composite index
             * you can introduce a column that is “hashed” based on information from other columns.
             * If this column is short, reasonably unique, and indexed,
             * it might be faster than a “wide” index on many columns.
             * In MySQL, it is very easy to use this extra column:
             * SELECT * FROM tbl_name
                WHERE hash_col=MD5(CONCAT(val1,val2))
                AND col1=val1 AND col2=val2;
             */
            $table->string('hash_name', 32)                           ->nullable(false)->index();
            $table->timestamps();
            $table->index(['last_name', 'first_name'], $this->getTable('sg') . '_name_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->getConnection())->dropIfExists($this->getTable());
    }
}
