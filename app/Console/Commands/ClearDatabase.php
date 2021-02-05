<?php

namespace App\Console\Commands;

use App\Episode;
use App\Rating;
use App\Title;
use Illuminate\Console\Command;

class ClearDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imdb:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Only series';

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
        $this->info('clear database');

        $count = Title::whereNull('startYear')->delete();
        $this->line("$count titles");

        $count = Episode::whereNotIn('title_id', function ($query) {
            $query->select('id')
                ->from('titles');
        })->orWhereNotIn('parent_id', function ($query) {
            $query->select('id')
                ->from('titles');
        })->orWhereNull('seasonNumber')
            ->orWhereNull('episodeNumber')
            ->delete();
        $this->line("$count episodes");

        $count = Rating::whereNotIn('id', function ($query) {
            $query->select('id')
                ->from('titles');
        })->delete();
        $this->line("$count ratings");

        return 0;
    }
}
