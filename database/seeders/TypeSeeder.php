<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serie = \App\Type::create(['type' => 'tvSeries']);
        $episode = \App\Type::create(['type' => 'tvEpisode']);

        \Illuminate\Support\Facades\Cache::forever('tvSeries', $serie->id);
        \Illuminate\Support\Facades\Cache::forever('tvEpisode', $episode->id);
    }
}
