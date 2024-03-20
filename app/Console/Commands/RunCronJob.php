<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class RunCronJob extends Command
{
    protected $signature = 'cronjob:run';

    protected $description = 'Run the cron job continuously';

    public function handle()
    {
        while (true) {
            // Get the URL for the route
            $url = URL::to('cron_job');

            // Trigger the route using file_get_contents or similar
            $response = file_get_contents($url);

            // Output the response or handle it as needed
            $this->info('Cron job executed successfully.');

            // Sleep for a specified time before running again (e.g., every minute)
            sleep(24 * 60 * 60); // Sleep for 24 hours
        }
    }
}
