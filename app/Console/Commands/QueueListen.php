<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class QueueListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to the queue';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Add your custom logic here
        $this->info('Queue listening started.');
    }
}
