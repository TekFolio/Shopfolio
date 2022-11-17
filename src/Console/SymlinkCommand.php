<?php

namespace Shopfolio\Console;

use Illuminate\Console\Command;

class SymlinkCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'shopfolio:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from "vendor/shopfolio" to "public/shopfolio" and add Storage symbolic link';

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        $link = public_path('shopfolio');
        $target = realpath(__DIR__ . '/../../public/');

        if (file_exists($link)) {
            $this->error('The "public/shopfolio" directory already exists.');
        } else {
            $this->laravel->make('files')->link($target, $link);
            $this->info('The [public/shopfolio] directory has been linked.');
        }

        $this->info('The link have been created.');
    }
}
