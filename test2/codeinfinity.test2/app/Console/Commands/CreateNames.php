<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PersonName;

class SQLiteConnection
{
    /**
     * PDO instance
     * @var type
     */
    private $pdo;

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() {
        if (($this->pdo == null) && (file_exists((env('DB_DATABASE').sprintf("%s",SQLITE_FILENAME))))) {
            $this->pdo = new \PDO("sqlite:" . env('DB_DATABASE').sprintf("%s",SQLITE_FILENAME));
        }
        return $this->pdo;
    }
}

class CreateNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:createNames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the database with some random names';

    /**
     * Create a new command instance.
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
        PersonName::Factory()->count(NUMBER_OF_NAMES_IN_ARRAY)->create();

        return 0;
    }
}
