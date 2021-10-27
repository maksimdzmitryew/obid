<?php

declare(strict_types=1);

namespace App\Traits;

use                  Illuminate\Database\Schema\Blueprint;
use                          Illuminate\Support\Carbon;
use                                         App\Model;
use                  Illuminate\Support\Facades\Schema;
use                          Illuminate\Support\Str;

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

    public function addPublished(Object $o_table, String $s_comment = NULL, ?Array $a_options = NULL) : void
    {
        $i_published = 0;
        if (isset($a_options['published']))
        {
            $i_published = $a_options['published'];
        }
        $o_table->boolean('published')                 ->default($i_published)->nullable(false)->index()->comment( $s_comment ?: 'item is confirmed and publicly available');
    }

    public function addForeignKey(Object $o_model, Object $o_table, ?Array $a_options = NULL, String $s_comment = NULL) : void
    {
        $s_comment = ($s_comment ?: '"' . $this->getPrefix() . $o_model->getTable() . '" table’s primary key');

        if (isset($a_options['id']))
        {
            if ($a_options['id'] == 'big')
            {
            $o_table->unsignedBigInteger($o_model->getAsForeignKey())                                   ->comment($s_comment);
            }
        }
        else
        {
            $o_table->unsignedInteger($o_model->getAsForeignKey())                                      ->comment($s_comment);
        }
    }

    public function getPrefix() : String
    {
        $s_tmp = $this->getConnection();
        $s_tmp = (empty($s_tmp) ? config('database.default') : $s_tmp);
        $s_tmp = config("database.connections.$s_tmp.prefix");
        return (!empty($s_tmp) ? $s_tmp : '');
    }

    public function addPrimaryKey(Object $o_model, Object $o_table, ?Array $a_options = NULL) : void
    {
        $s_comment = 'primary identifier';
        if (isset($a_options['id']))
        {
            if ($a_options['id'] == 'big')
            {
            $o_table->bigIncrements($o_model->getPrimary())                                             ->comment($s_comment);
            }
        }
        else
        {
            $o_table->increments($o_model->getPrimary())                                                ->comment($s_comment);
        }
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
            $s_tmp = str_replace(['Create', 'Table', ], '', $s_tmp);
            $s_tmp = Str::snake($s_tmp);

#            $a_tmp = explode('_', $s_tmp);
#            $i_pos = array_search('table', $a_tmp);
#            $s_tmp = $a_tmp[$i_pos-1];
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
    public function upMajorMigration(?Blueprint $o_table = NULL, Array $a_options = NULL) : void
    {
        Schema::connection($this->getConnection())->create($this->getTable(), function (Blueprint $table) use ($o_table, $a_options) {
            $this->addPrimaryKey($this, $table, $a_options);
            $this->addPublished($table, NULL, $a_options);

            self::addCustomColumns($table, $o_table);

            $this->addDates($table);
        });
    }

    /**
     * common structure for any translation table
     */
    public function upTranslationMigration(?Blueprint $o_table = NULL, Array $a_options = NULL) : void
    {
        Schema::connection($this->getConnection())->create($this->getTransTableName(), function (Blueprint $table) use ($o_table, $a_options) {

            $this->addPrimaryKey($this, $table, $a_options);
            $this->addForeignKey($this, $table, $a_options);

            $table->char('locale', 2)                       ->default('')->nullable(false)->index()     ->comment('ISO 639-1:2002 alpha-2 language code');
            $table->unique([$this->getAsForeignKey(), 'locale'])                                        ->comment('combination of translation for locale');

            self::addCustomColumns($table, $o_table);

            $table->foreign(
                $this->getAsForeignKey(),
                /**
                 * custom name to avoid duplicates
                 * because Laravel does not add prefixes to FKs
                 * which might result in FK bearing non-unique names across tables
                 * which will throw an error
                 * https://stackoverflow.com/questions/31569804/why-do-mysql-foreign-key-constraint-names-have-to-be-unique
                 * this also means Laravel won't auto-recognise such names ((
                 */
                $this->getPrefix() . $this->getTransTableName() . '_' . $this->getAsForeignKey() . '_foreign'
            )->references($this->getPrimary())->on($this->getTable())->onDelete('cascade');

        });
    }

    /**
     *  run seeder to fill in this module's table
     */
    public function runSeedTable() : void
    {
        $s_table_name = $this->getTable('sg');
        $s_model_main = Model::getModelNameWithNamespace($s_table_name);
        $s_model_seed = Model::getModelSeederWithNamespace($s_model_main);
        Model::seedTableMainAndTranslation($s_model_main, $s_model_seed);
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
