<?php

namespace Database\Seeders;

use App\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serie = Type::create(['type' => 'tvSeries']);
        $episode = Type::create(['type' => 'tvEpisode']);
        $miniSerie = Type::create(['type' => 'tvMiniSeries']);

        Cache::forever('tvSeries', $serie->id);
        Cache::forever('tvEpisode', $episode->id);
        Cache::forever('tvMiniSeries', $miniSerie->id);
    }
}
