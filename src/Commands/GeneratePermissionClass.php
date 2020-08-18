<?php

namespace LaravelSimpleBases\Commands;

use Illuminate\Console\Command;
use LaravelSimpleBases\Templates\ControllerTemplate;
use LaravelSimpleBases\Templates\ModelTemplate;
use LaravelSimpleBases\Templates\PermissionTemplate;
use LaravelSimpleBases\Templates\ServiceTemplate;
use LaravelSimpleBases\Templates\TransformerTemplate;
use LaravelSimpleBases\Templates\ValidationTemplate;

class GeneratePermissionClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabio-pv:generate-permission-class {name} {--api-version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates permission class';

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

        $name = $this->argument('name');
        $versionName = $this->option('api-version');

        PermissionTemplate::instance()->make($name, $versionName);

        return 0;
    }
}
