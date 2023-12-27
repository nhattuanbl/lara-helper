<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Deerdama\ConsoleZoo\ConsoleZoo;
use Elastic\Adapter\Indices\Index;
use Elastic\Adapter\Indices\IndexManager;
use Illuminate\Console\Command;
use Elastic\Client\ClientBuilder;

class ElasticPing extends Command
{
    use ConsoleZoo;
    protected $signature = 'elastic:ping';

    protected $description = 'Test elasticsearch connection and authentication';

    public function handle()
    {
        $connection = \Config::get('elastic.client.default');
        list($host, $port) = explode(':', \Config::get("elastic.client.connections.$connection.hosts")[0]);

        $this->output->write("Checking connection to [$host:$port] on connection [$connection]... ");
        if($fp = fsockopen($host, $port,$errCode,$errStr,2)) {
            $this->zoo('', ['icons' => 'white_heavy_check_mark']);
        } else {
            $this->zoo($errCode, ['icons' => 'cross_mark']);
        }
        fclose($fp);

        $this->output->write("Checking authentication... ");
        $index_manager = new IndexManager(new ClientBuilder);
        $index_manager->create(new Index('my_test_index'));
        if ($index_manager->exists('my_test_index')) {
            $this->zoo('', ['icons' => 'white_heavy_check_mark']);
        } else {
            $this->zoo($errCode, ['icons' => 'cross_mark']);
        }
        $index_manager->drop('my_test_index');
    }
}
