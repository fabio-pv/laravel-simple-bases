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
    protected $description = 'Command description';

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
        dd('oioioioioi');
        return 0;
    }
}
