<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaveDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imdb:save {--T|title} {--E|episode} {--R|rating}';

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
        $all = ! $this->option('title')
            && ! $this->option('episode')
            && ! $this->option('rating');

        if ($all || $this->option('title')) {
            $this->info('title');
            $this->titleToDatabase();
        }

        if ($all || $this->option('episode')) {
            $this->info('episode');
            $this->episodeToDatabase();
        }

        if ($all || $this->option('rating')) {
            $this->info('rating');
            $this->ratingToDatabase();
        }

        return 0;
    }

    private function titleToDatabase()
    {
        $tmp = 'unzip/tmp.tsv';
        $path = Storage::disk(config('imdb.disk'))->path('unzip/title.basics.tsv');
        $out = Storage::disk(config('imdb.disk'))->path($tmp);

        if (! Storage::disk(config('imdb.disk'))->exists($tmp)) {
            $this->line('awk...');

            $awk = 'awk \'/tvSeries/ || /tvEpisode/ || /tvMiniSeries/\' '.$path.' > '.$out;
            exec($awk);
        }

        $database = config('database.connections.mysql.database');
        $tvSeries = Cache::get('tvSeries');
        $tvEpisode = Cache::get('tvEpisode');
        $tvMiniSeries = Cache::get('tvMiniSeries');

        $sql = "LOAD DATA LOCAL INFILE '$out'
            REPLACE INTO TABLE $database.titles
            FIELDS TERMINATED BY '\t'
            LINES TERMINATED BY '\n'
            (@id,@type_id,@primaryTitle,@originalTitle,isAdult,startYear,@endYear,@runtimeMinutes,@dummy)
            SET id = CAST(REPLACE(@id,'tt','') AS UNSIGNED),
                type_id = CASE
                    WHEN @type_id = 'tvSeries' THEN $tvSeries
                    WHEN @type_id = 'tvEpisode' THEN $tvEpisode
                    WHEN @type_id = 'tvMiniSeries' THEN $tvMiniSeries
                END,
                primaryTitle = LEFT(@primaryTitle, 255),
                originalTitle = LEFT(@originalTitle, 255),
                endYear = IF(STRCMP(@endYear,'\\N') = 0, NULL, @endYear),
                runtimeMinutes = IF(STRCMP(@runtimeMinutes,'\\N') = 0, NULL, @runtimeMinutes);";

        try {
            $this->line('database...');

            Log::info($sql);

            DB::connection()->getPdo()->exec($sql);
            Storage::disk(config('imdb.disk'))->delete($tmp);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }

        $this->line('finish');
    }

    private function episodeToDatabase()
    {
        $database = config('database.connections.mysql.database');
        $episode = Storage::disk(config('imdb.disk'))->path('unzip/title.episode.tsv');

        $sql = "LOAD DATA INFILE '$episode'
            REPLACE INTO TABLE $database.episodes
            FIELDS TERMINATED BY '\t'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (@title_id,@parent_id,@seasonNumber,@episodeNumber)
            SET title_id = CAST(REPLACE(@title_id,'tt','') AS UNSIGNED),
                parent_id = CAST(REPLACE(@parent_id,'tt','') AS UNSIGNED),
                seasonNumber = IF(STRCMP(@seasonNumber,'\\N') = 0, NULL, @seasonNumber),
                episodeNumber = IF(STRCMP(@episodeNumber,'\\N') = 0, NULL, @episodeNumber);";

        try {
            $this->line('database...');

            DB::connection()->getPdo()->exec($sql);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }

        $this->line('finish');
    }

    private function ratingToDatabase()
    {
        $database = config('database.connections.mysql.database');
        $episode = Storage::disk(config('imdb.disk'))->path('unzip/title.ratings.tsv');

        $sql = "LOAD DATA INFILE '$episode'
            REPLACE INTO TABLE $database.ratings
            FIELDS TERMINATED BY '\t'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (@id,averageRating,numVotes)
            SET id = CAST(REPLACE(@id,'tt','') AS UNSIGNED);";

        try {
            $this->line('database...');

            DB::connection()->getPdo()->exec($sql);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }

        $this->line('finish');
    }
}
