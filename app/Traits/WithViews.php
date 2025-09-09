<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

trait WithViews
{
    protected function views(): Attribute
    {
        return Attribute::get(fn() => intval($this->getMeta('views', 0)));
    }
    protected function viewsFormatted(): Attribute
    {
        return Attribute::get(fn() => human_number($this->views));
    }
    public function viewsPlus()
    {
        $views = $this->views + 1;
        $this->updateMeta('views', $views);
    }
    public function scopePopular(Builder $query): Builder
    {
        $modelClass = static::class;
        $table = $this->getTable();

        return $query
            ->leftJoin('metas', function ($join) use ($modelClass, $table) {
                $join->on('metas.model_id',   '=', "{$table}.id")
                    ->where('metas.model_type', '=', $modelClass)
                    ->where('metas.key',        '=', 'views');
            })
            ->select("{$table}.*")
            ->selectRaw('COALESCE(CAST(metas.value AS UNSIGNED), 0) AS views_count')
            ->orderBy('views_count', 'desc');
    }
}
