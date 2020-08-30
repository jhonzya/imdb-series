<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class TitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'primaryTitle' => $this->primaryTitle,
            'profile' => $this->when($this->type_id == Cache::get('tvSeries'), function () {
                return route('series', ['title' => $this->id]);
            }),
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
            'rating' => new RatingResource($this->whenLoaded('rating')),
        ];
    }
}
