<?php

namespace LaravelSimpleBases\Commands;

use Illuminate\Console\Command;
use LaravelSimpleBases\Templates\ControllerTemplate;
use LaravelSimpleBases\Templates\ModelTemplate;
use LaravelSimpleBases\Templates\ServiceTemplate;
use LaravelSimpleBases\Templates\TransformerTemplate;
use LaravelSimpleBases\Templates\ValidationTemplate;

class GenerateEndpointClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabio-pv:generate-endpoint-class {name} {--table-name=} {--api-version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the main classes that make up an endpoint';

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
        $tableName = $this->option('table-name');
        $versionName = $this->option('api-version');

        if(empty($tableName)){
            echo "\e[0;31mOption '--table-name=' is required\e[0m\n";
            echo PHP_EOL;
            return;
        }

        ControllerTemplate::instance()->make($name, $versionName);
        ServiceTemplate::instance()->make($name, $versionName);
        ValidationTemplate::instance()->make($name, $versionName);
        ModelTemplate::make($name, $tableName);
        TransformerTemplate::make($name, $versionName);

        return 0;
    }
}
