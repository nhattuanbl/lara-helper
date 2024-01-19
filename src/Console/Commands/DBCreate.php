<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Illuminate\Console\Command;

class DBCreate extends Command
{
    protected $signature = 'db:create {name?} {connection=mysql}';

    protected $description = 'Create a new database if it does not exist';

    public function handle()
    {
        $connectionName = $this->argument('connection');
        $dbName = $this->argument('name') ?: config("database.connections.$connectionName.database");
        $connectionConfig = config("database.connections.{$connectionName}");

        if (!$connectionConfig) {
            $this->error("The specified connection [{$connectionName}] does not exist.");
            return;
        }

        try {
            $pdo = \DB::connection($connectionName)->getPdo();
            $pdo->exec("CREATE DATABASE \"$dbName\"");

            $this->info("Database '$dbName' created or already exists on '$connectionName' connection");
        } catch (\PDOException $e) {
            if ($e->getCode() == '42P04') {
                $this->info("Database '$dbName' already exists on '$connectionName' connection");
            } else {
                $this->error("Error: " . $e->getMessage());
            }
        }
    }
}
