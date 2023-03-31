<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MongoDB\Client;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_database {name}';

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
        DB::getConnection()->statement('use :schema', ['schema' => $this->argument('name')]);
        return 0;
    }
}
