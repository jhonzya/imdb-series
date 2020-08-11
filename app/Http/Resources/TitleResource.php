<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'profile' => route('series', ['title' => $this->id]),
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
            'rating' => new RatingResource($this->whenLoaded('rating')),
        ];
    }
}
