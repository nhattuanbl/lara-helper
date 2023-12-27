<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Deerdama\ConsoleZoo\ConsoleZoo;
use Illuminate\Console\Command;
use MongoDB\Client;

class MongoPing extends Command
{
    use ConsoleZoo;
    protected $signature = 'mongo:ping';

    protected $description = 'Test mongodb connection';

    public function handle()
    {
        $connection = config('database.connections.mongodb');
        $host = $connection['host'];
        $port = $connection['port'];
        $this->output->write("Checking connection to [$host:$port] on connection [".$connection['driver']."]... ");

        if($fp = fsockopen($host, $port,$errCode,$errStr,2)) {
            $this->zoo('', ['icons' => 'white_heavy_check_mark']);
        } else {
            $this->zoo($errCode, ['icons' => 'cross_mark']);
        }
        fclose($fp);

        $version = (float) implode('.', explode('.', PHP_VERSION));
        if ($version <= 7.3) {
            $clientMongo = new \MongoDB\Client("mongodb://$host:$port");
        } else {
            $clientMongo = new \MongoDB\Client("mongodb://$host:$port");
        }

        $this->output->write("Checking authentication... ");
        $client = new Client("mongodb://$host:$port");
        if  ($client->selectDatabase('admin')) {
            $this->zoo('', ['icons' => 'white_heavy_check_mark']);
        } else {
            $this->zoo('', ['icons' => 'cross_mark']);
        }
    }
}
