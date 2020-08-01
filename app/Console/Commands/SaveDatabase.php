<?php

namespace App\Console\Commands;

use App\Episode;
use App\Title;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SaveDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imdb:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Title::unguard();
        Episode::unguard();

        $this->titleToDatabase();
        $this->episodeToDatabase();

        Title::reguard();
        Episode::reguard();

        return 0;
    }

    private function titleToDatabase()
    {
        $this->info('title.basics');

        $tmp = 'unzip/tmp.tsv';
        $path = Storage::disk(config('imdb.disk'))->path('unzip/title.basics.tsv');
        $out = Storage::disk(config('imdb.disk'))->path($tmp);

        $awk = 'awk \'/tvSeries/ || /tvEpisode/\' '.$path.' > '.$out;
        exec($awk);

        $count = 0;
        $min = config('imdb.minYear');
        $types = [
            'tvSeries' => Cache::get('tvSeries'),
            'tvEpisode' => Cache::get('tvEpisode'),
        ];

        foreach ($this->yieldTsv($tmp) as $tsv) {
            $startYear = $tsv[5];
            if ($startYear < $min) {
                continue;
            }

            $id = str_replace('tt', '', $tsv[0]);

            Title::create([
                'id' => intval($id),
                'primaryTitle' => Str::limit($tsv[2], 252),
                'originalTitle' => Str::limit($tsv[3], 252),
                'isAdult' => boolval($tsv[4]),
                'startYear' => $tsv[5],
                'endYear' => $tsv[6] == '\\N' ? null : $tsv[6],
                'runtimeMinutes' => $tsv[7] == '\\N' ? null : $tsv[7],
                'type_id' => $types[$tsv[1]],
            ]);

            $count++;
        }

        $this->info("$count registros");
        Storage::disk(config('imdb.disk'))->delete($tmp);
    }

    private function episodeToDatabase()
    {
        $this->info('title.episode');

        $first = true;
        $count = 0;

        foreach ($this->yieldTsv('unzip/title.episode.tsv') as $tsv) {
            if($first) {
                $first = false;
                continue;
            }

            $title = str_replace('tt', '', $tsv[0]);
            $parent = str_replace('tt', '', $tsv[1]);

            Episode::create([
                'title_id' => intval($title),
                'parent_id' => intval($parent),
                'seasonNumber' => $tsv[2] == '\\N' ? null : $tsv[2],
                'episodeNumber' => $tsv[3] == '\\N' ? null : $tsv[3],
            ]);

            $count++;
        }

        $this->info("$count registros");
    }

    /**
     * @param $file
     * @return \Generator
     */
    private function yieldTsv($file)
    {
        $path = Storage::disk(config('imdb.disk'))->path($file);
        $fileManager = fopen($path, 'r');

        while (($data = fgetcsv($fileManager, 0, "\t")) !== false) {
            yield $data;
        }

        fclose($fileManager);
    }
}
