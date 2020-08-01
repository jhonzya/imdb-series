<?php

namespace App\Console\Commands;

use App\Title;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

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

        $this->titleToDatabase();

        Title::reguard();
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
                'primaryTitle' => $tsv[2],
                'originalTitle' => $tsv[3],
                'isAdult' => boolval($tsv[4]),
                'startYear' => $tsv[5],
                'endYear' => $tsv[6] == '\\N' ? null : $tsv[6],
                'runtimeMinutes' => $tsv[7] == '\\N' ? null : $tsv[7],
                'type_id' => $types[$tsv[1]],
            ]);

            $count++;

            if ($count >= 10) {
                break;
            }
        }

        $this->info("$count registros");
        Storage::disk(config('imdb.disk'))->delete($tmp);
    }

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
