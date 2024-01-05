<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Illuminate\Console\Command;

class MysqlPing extends Command
{
    protected $signature = 'mysql:ping {--C|connection=mysql} {--T|timeout=2}';

    protected $description = 'Test mysql connection and authentication';

    public function handle()
    {
        $timeout = $this->option('timeout');
        $connectionName = $this->option('connection');
        $connection = config("database.connections.$connectionName");
        if (!$connection) {
            $this->error("Connection [$connectionName] not configured.");
            return;
        }

        $this->output->write("Checking connection to [".$connection['host'].":".$connection['port']."] on connection [$connectionName]... ");
        if($fp = @fsockopen($connection['host'], $connection['port'],$errCode,$errStr, $timeout)) {
            fclose($fp);
            $this->info('✅  Connection established.');
            $this->output->write("Checking authentication... ");
            try {
                \DB::connection($connectionName)->getPdo();
                $this->info('✅  Authentication successful.');
            } catch (\Exception $e) {
                $this->error("❌  Authentication failed - " . $e->getMessage());
            }
        } else {
            $this->error("❌  Connection failed - $errStr ($errCode)");
        }
    }
}
