<?php

namespace App\Traits;

use               Illuminate\Database\Schema\Blueprint;
use                       Illuminate\Support\Carbon;
use               Illuminate\Support\Facades\Schema;
use                       Illuminate\Support\Str;

trait MigrationTrait
{
    protected static $s_primary                 = 'id';
    protected static $s_table_migration         = '';
    protected static $s_table_translation       = 'translations';

    public function getConnection() : String
    {
        return self::DB_CONNECTION;
    }

    private function addCustomColumns(Object $table, ?Object $o_table) : void
    {
        $a_columns = [];
        if (!is_null($o_table))
        {
            $a_columns = ($o_table->getColumns());
        }
        foreach ($a_columns as $key => $a_column) {
            $table->addColumn('tmp_type', 'tmp_name', end($a_column));
        }
    }

    public function addDates(Object $o_table) : void
    {
        /**
         *  useCurrent() will assign CURRENT_TIMESTAMP if not value is set
         */
        $o_table->dateTime('published_at')                  ->useCurrent()  ->nullable(false)           ->comment( 'only after this date item’s available to public if it’s also "published"; and also is shown in human readable presentation');
        $o_table->timestamps();
    }

    public function addPublished(Object $o_table, String $s_comment = NULL) : void
    {
        $o_table->boolean('published')                      ->default(0)    ->nullable(false)->index()  ->comment( $s_comment ?: 'item is confirmed and publicly available');
    }

    public function addForeignKey(Object $o_model, Object $o_table, String $s_comment = NULL) : void
    {
        $o_table->unsignedInteger($o_model->getAsForeignKey())                                          ->comment($s_comment ?: '"' . $this->getPrefix() . $o_model->getTable() . '" table’s primary key')
        ;
    }

    public function getPrefix() : String
    {
        $s_tmp = $this->getConnection();
        $s_tmp = (empty($s_tmp) ? config('database.default') : $s_tmp);
        $s_tmp = config("database.connections.$s_tmp.prefix");
        return (!empty($s_tmp) ? $s_tmp : '');
    }

    public function addPrimaryKey(Object $o_model, Object $o_table) : void
    {
        $o_table->increments($o_model->getPrimary())                                                    ->comment('primary identifier');
    }

    public function getPrimary() : String
    {
        return self::$s_primary;
    }

    public function getTable(String $s_type = 'pl') : String
    {
        $s_tmp = $this->_getTableGuess();

        switch ($s_type)
        {
            case 'sg': $s_name = Str::singular($s_tmp); break;
            case 'pl': $s_name = Str::plural($s_tmp); break;
            default: $s_name = $s_tmp; break;
        }
        return $s_name;
    }

    private function _getTableGuess() : String
    {
        $s_tmp = self::$s_table_migration;
        if (empty($s_tmp))
        {
            $s_tmp = get_class($this);
            $s_tmp = Str::snake($s_tmp);
            $a_tmp = explode('_', $s_tmp);
            $i_pos = array_search('table', $a_tmp);
            $s_tmp = $a_tmp[$i_pos-1];
        }
        return $s_tmp;
    }

    public function getTransTableName() : String
    {
        return $this->getTable('sg') . '_' . self::$s_table_translation;
    }

    public function getAsForeignKey() : String
    {
        return $this->getTable('sg') . '_' . $this->getPrimary();
    }

    private function getClassForCustomColumns() : Blueprint
    {
        return new Blueprint('tmp');
    }

    /**
     * common structure for any table
     */
    public function upMajorMigration(?Blueprint $o_table = NULL) : void
    {
        Schema::connection($this->getConnection())->create($this->getTable(), function (Blueprint $table) use ($o_table) {
            $this->addPrimaryKey($this, $table);
            $this->addPublished($table);

            self::addCustomColumns($table, $o_table);

            $this->addDates($table);
        });
    }

    /**
     * common structure for any translation table
     */
    public function upTranslationMigration(?Blueprint $o_table = NULL) : void
    {
        Schema::connection($this->getConnection())->create($this->getTransTableName(), function (Blueprint $table) use ($o_table) {

            $this->addPrimaryKey($this, $table);
            $this->addForeignKey($this, $table);

            $table->char('locale', 2)                       ->default('')->nullable(false)->index()     ->comment('ISO 639-1:2002 alpha-2 language code');
            $table->unique([$this->getAsForeignKey(), 'locale'])                                        ->comment('combination of translation for locale');

            self::addCustomColumns($table, $o_table);

            $table->foreign($this->getAsForeignKey())->references($this->getPrimary())->on($this->getTable())->onDelete('cascade');

        });
    }

    public function downMajorMigration() : void
    {
        Schema::connection($this->getConnection())->dropIfExists($this->getTable());
    }

    public function downTranslationMigration() : void
    {
        Schema::connection($this->getConnection())->dropIfExists($this->getTransTableName());
    }

}
