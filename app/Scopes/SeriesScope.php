<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Cache;

class SeriesScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('type_id', Cache::get('tvSeries'));
    }
}
