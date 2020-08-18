<?php

namespace LaravelSimpleBases\Commands;

use Illuminate\Console\Command;

class GeneratePermissionHandle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabio-pv:generate-permission-handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create class handle to permission';

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
        $source = getcwd() . '/vendor/fabio/laravel-simple-bases/src/Http/Permissions/HandlePermission.php';
        $dest = getcwd() . '/app/Http/Permissions/';
        $fileName = 'HandlePermission.php';

        if (is_dir($dest) === false) {
            mkdir($dest, 0777, true);
        }

        $result = copy($source, $dest . $fileName);

        if ($result === true) {
            echo 'Generate file in ' . $dest;
            echo PHP_EOL;
        }

        return 0;
    }
}
