<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReverbStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverb:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the reverb process';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Add your custom logic here
        $this->info('Reverb process started.');
    }
}
