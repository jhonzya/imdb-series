<?php

namespace App;

use App\Scopes\SeriesScope;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    // relationships

    public function title()
    {
        return $this->belongsTo('App\Title')
            ->withoutGlobalScope(SeriesScope::class)
            ->with('rating');
    }

    public function rating()
    {
        return $this->hasOne('App\Rating', 'id', 'title_id');
    }
}
