<?php

namespace Shopfolio\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopfolio:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the Shopfolio resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'shopfolio-config',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'shopfolio-seeders',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'shopfolio-lang',
            '--force' => $this->option('force'),
        ]);
    }
}
