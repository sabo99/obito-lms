<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunToolsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run ide-helper and Pint commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running ide-helper:models -RW (Reset existing phpdocs and Write to the models directly)');
        $this->call('ide-helper:models', [
            '--reset' => true,
            '--write' => true,
        ]);

        $this->info('Running Pint code formatter...');
        exec('php ./vendor/bin/pint', $output, $exitCode);
        foreach ($output as $line) {
            $this->line($line);
        }

        $this->info('All commands executed successfully!');

        return 0;
    }
}
