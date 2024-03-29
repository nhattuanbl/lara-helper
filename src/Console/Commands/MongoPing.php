<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Deerdama\ConsoleZoo\ConsoleZoo;
use Illuminate\Console\Command;
use MongoDB\Client;

class MongoPing extends Command
{
    use ConsoleZoo;
    protected $signature = 'mongo:ping {connection=mongodb} {--T|timeout=2}';

    protected $description = 'Test mongodb connection';

    public function handle()
    {
        $timeout = $this->option('timeout');
        $connectionName = $this->argument('connection');
        $connection = config("database.connections.$connectionName");
        $this->output->write("Checking connection to [".$connection['host'].":".$connection['port']."] on connection [$connectionName]... ");
        if($fp = @fsockopen($connection['host'], $connection['port'],$errCode,$errStr, $timeout)) {
            fclose($fp);
            $this->info('✅  Connection established.');
            $this->output->write("Checking authentication... ");
            try {
                $clientMongo = new \MongoDB\Client(
                    "mongodb://{$connection['username']}:{$connection['password']}@{$connection['host']}:{$connection['port']}",
                    [],
                    ['typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array']]
                );

                $clientMongo->selectDatabase('admin')->listCollections();
                $this->info('✅  Authentication successful.');
            } catch (\Exception $e) {
                $this->error("❌  Authentication failed - " . $e->getMessage());
            }
        } else {
            $this->error("❌  Connection failed - $errStr ($errCode)");
        }
    }
}
