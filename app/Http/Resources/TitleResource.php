<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class TitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'primaryTitle' => $this->primaryTitle,
            'startYear' => $this->startYear,
            'type' => $this->type,
            'profile' => $this->when($this->type_id == Cache::get('tvSeries'), function () {
                return route('series', ['title' => $this->id]);
            }),
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
            'rating' => new RatingResource($this->whenLoaded('rating')),
        ];
    }
}
