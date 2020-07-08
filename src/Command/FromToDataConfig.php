<?php

namespace LaravelSimpleBases\Commands;

use Illuminate\Console\Command;

class FromToDataConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabio-pv:from-to-data-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the file to intercept the uuid in the request';

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
        $source = getcwd() . '/vendor/fabio/laravel-simple-bases/src/config/from_to_data.php';
        $dest = getcwd() . '/config/from_to_data.php';
        $result = copy($source, $dest);

        if ($result === true) {
            echo 'Generate file in ' . $dest;
            echo PHP_EOL;
        }

        return 0;
    }
}
