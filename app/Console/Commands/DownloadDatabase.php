<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imdb:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download database: https://datasets.imdbws.com';

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
        $url = config('imdb.url');

        foreach (config('imdb.files') as $file) {
            $this->info("Downloading $file ...");

            try {
                Storage::disk(config('imdb.disk'))->put($file, fopen($url.$file, 'r'));
            } catch (\Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        return 0;
    }
}
