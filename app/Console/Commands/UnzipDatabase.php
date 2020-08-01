<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UnzipDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imdb:unzip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unzip database';

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
        Storage::disk('imdb')->makeDirectory('unzip');

        foreach (config('imdb.files') as $file) {
            $this->info("Unzip $file ...");

            $unzip = str_replace('.gz', '', $file);
            $buffer = 4096;

            $path = Storage::disk('imdb')->path($file);
            $outPath = Storage::disk('imdb')->path("unzip/$unzip");

            $file = gzopen($path, 'rb');
            $outFile = fopen($outPath, 'wb');

            while (!gzeof($file)) {
                fwrite($outFile, gzread($file, $buffer));
            }

            fclose($outFile);
            gzclose($file);
        }

        return 0;
    }
}
