<?php

namespace App;

use App\Scopes\SeriesScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;

class Title extends Model
{
    use Searchable;

    public $incrementing = false;
    public $timestamps = false;
    protected $appends = ['link', 'api', 'type'];
    protected $with = ['rating'];

    protected static function booted()
    {
        static::addGlobalScope(new SeriesScope());
    }

    public function getLinkAttribute(): string
    {
        $id = str_pad($this->attributes['id'], 7, '0', STR_PAD_LEFT);
        $website = config('imdb.website');

        return $website.'title/tt'.$id;
    }

    public function getTypeAttribute(): string
    {
        $types = [
            Cache::get('tvSeries') => 'TV Serie',
            Cache::get('tvEpisode') => 'TV Episode',
            Cache::get('tvMiniSeries') => 'TV Mini Serie',
        ];

        return $types[$this->type_id];
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

    // searchable

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'primaryTitle' => $this->primaryTitle,
            'originalTitle' => $this->originalTitle,
        ];
    }
}
