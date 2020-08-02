<?php

namespace App;

use App\Scopes\SeriesScope;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(new SeriesScope());
    }

    // relationships

    public function episodes()
    {
        return $this->hasMany('App\Episode', 'parent_id')
            ->orderBy('seasonNumber')
            ->orderBy('episodeNumber');
    }

    public function rating()
    {
        return $this->hasOne('App\Rating', 'id');
    }
}
