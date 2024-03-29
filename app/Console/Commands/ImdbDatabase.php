<?php

namespace App\Console\Commands;

use App\Title;
use Illuminate\Console\Command;

class ImdbDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imdb:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $title = Title::class;

        $this->call('imdb:download');
        $this->call('imdb:unzip');
        $this->call('imdb:save');
        $this->call('imdb:clear');
        $this->call("scout:import '$title'");

        return 0;
    }
}
