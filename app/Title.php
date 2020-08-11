<?php

namespace App;

use App\Scopes\SeriesScope;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $appends = ['link', 'api'];

    protected static function booted()
    {
        static::addGlobalScope(new SeriesScope());
    }

    public function getApiAttribute()
    {
        return route('show', ['title' => $this->attributes['id']]);
    }

    public function getLinkAttribute()
    {
        $id = str_pad($this->attributes['id'], 7, '0', STR_PAD_LEFT);
        $website = config('imdb.website');

        return $website.'title/tt'.$id;
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
