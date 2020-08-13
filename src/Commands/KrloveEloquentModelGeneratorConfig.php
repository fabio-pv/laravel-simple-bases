<?php

namespace LaravelSimpleBases\Commands;

use Illuminate\Console\Command;

class KrloveEloquentModelGeneratorConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabio-pv:krlove-eloquent-model-generator-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a configuration file for the package krlove/eloquent-model-generator';

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
        $source = getcwd() . '/vendor/fabio/laravel-simple-bases/src/config/eloquent_model_generator.php';
        $dest = getcwd() . '/config/eloquent_model_generator.php';
        $result = copy($source, $dest);

        if ($result === true) {
            echo 'Generate file in ' . $dest;
            echo PHP_EOL;
        }

        return 0;
    }
}
