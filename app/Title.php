<?php

namespace App;

use App\Scopes\SeriesScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Title extends Model
{
    use Searchable;

    public $incrementing = false;
    public $timestamps = false;
    protected $appends = ['link', 'api'];

    protected static function booted()
    {
        static::addGlobalScope(new SeriesScope());
    }

    public function getApiAttribute(): string
    {
        return route('show', ['title' => $this->attributes['id']]);
    }

    public function getLinkAttribute(): string
    {
        $id = str_pad($this->attributes['id'], 7, '0', STR_PAD_LEFT);
        $website = config('imdb.website');

        return $website.'title/tt'.$id;
    }

    // relationships

    public function episodes(): HasMany
    {
        return $this->hasMany('App\Episode', 'parent_id')
            ->orderBy('seasonNumber')
            ->orderBy('episodeNumber');
    }

    public function rating(): HasOne
    {
        return $this->hasOne('App\Rating', 'id');
    }
}
