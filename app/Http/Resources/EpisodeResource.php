<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'seasonNumber' => $this->seasonNumber,
            'episodeNumber' => $this->episodeNumber,
            'rating' => $this->rating,
        ];
    }
}
