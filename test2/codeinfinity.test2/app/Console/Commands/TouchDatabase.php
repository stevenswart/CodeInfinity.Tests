<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

define('SQLITE_FILENAME','/database.sqlite');

class TouchDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:touchDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an empty file to be used as the SQlite database';

    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    /**
     * Connect to the SQLite database.
     *
     * @return void
     */
    public function __construct()
    {
        $connection = new SQLiteConnection();
        $this->pdo = $connection->connect();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('This will delete the existing SQLite database, and all the data in it! Continue?'))
        {
            if (file_exists(env('DB_DATABASE').sprintf("%s",SQLITE_FILENAME)))
            {
                unlink(env('DB_DATABASE').sprintf("%s",SQLITE_FILENAME));
            }
            if ( !file_exists(env('DB_DATABASE')) || !is_dir(env('DB_DATABASE')) )
            {
                mkdir(env('DB_DATABASE'));
            }
            $db = fopen(env('DB_DATABASE').sprintf("%s",SQLITE_FILENAME), "w");
            fclose($db);
            return 1;
        }

        return 0;
    }
}
