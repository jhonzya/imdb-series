<?php

namespace App\Http\Controllers;

use App\Title;
use App\Http\Resources\TitleResource;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function search(Request $request)
    {
        $titles = Title::where('primaryTitle', 'like', '%'.$request->get('q').'%')
            ->limit(10)->get();

        return TitleResource::collection($titles);
    }

    public function show(Title $title)
    {
        $title->load('episodes');

        return new TitleResource($title);
    }
}
