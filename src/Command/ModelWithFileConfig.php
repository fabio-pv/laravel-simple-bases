<?php

namespace LaravelSimpleBases\Commands;

use Illuminate\Console\Command;

class ModelWithFileConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabio-pv:model-with-file-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the file to intercept base64 on request';

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
        $source = getcwd() . '/vendor/fabio/laravel-simple-bases/src/config/model_with_file.php';
        $dest = getcwd() . '/config/model_with_file.php';
        $result = copy($source, $dest);

        if ($result === true) {
            echo 'Generate file in ' . $dest;
            echo PHP_EOL;
        }

        return 0;
    }
}
