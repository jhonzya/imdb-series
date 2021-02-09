<?php

namespace App\Http\Controllers;

use App\Http\Resources\TitleResource;
use App\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function search(Request $request)
    {
        $titles = Title::search($request->get('q'))
            ->get()
            ->sortByDesc(function ($title) {
                return $title->rating->numVotes ?? 0;
            })
            ->take(10);

        return TitleResource::collection($titles);
    }

    public function show(Title $title)
    {
        $title->load('episodes');

        return new TitleResource($title);
    }

    public function episode(Title $title)
    {
        return new TitleResource($title);
    }
}
