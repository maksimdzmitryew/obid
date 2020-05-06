<?php 

namespace App\Filters;

use App\Filters\Filters;
use Illuminate\Http\Request;

class SettingsFilters extends Filters
{
    protected $filters = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    protected function name($name)
    {
        return $this->builder->whereTranslationLike('name', '%' . $name . '%', $this->appLocale);
    }

    protected function getQuery()
    {
        return $this->builder->select('settings.*', 'setting_translations.name as name')
            ->offset($this->request->start)
            ->limit($this->limit)
            ->leftJoin('setting_translations', function($query) {
                $query->on('setting_translations.setting_id', '=', 'settings.id')
                    ->where('locale', '=', $this->appLocale);
            })
            ->orderBy($this->orderColumn, $this->orderDirection);
    }
}