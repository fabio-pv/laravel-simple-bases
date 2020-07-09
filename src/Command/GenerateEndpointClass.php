<?php

namespace LaravelSimpleBases\Commands;

use Illuminate\Console\Command;
use LaravelSimpleBases\Templates\ControllerTemplate;

class GenerateEndpointClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabio-pv:generate-endpoint-class {name}';

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

        ControllerTemplate::instance()->make($name);

        return 0;
    }
}
