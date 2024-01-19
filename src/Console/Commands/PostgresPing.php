<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Illuminate\Console\Command;

class PostgresPing extends Command
{
    protected $signature = 'postgres:ping {connection=pgsql} {--T|timeout=2}';

    protected $description = 'Test PostgresSQL connection and authentication';

    public function handle()
    {
        $timeout = $this->option('timeout');
        $connectionName = $this->argument('connection');
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
                $pdo = new \PDO('pgsql:host=' . $connection['host'] . ';port=' . $connection['port'], $connection['username'], $connection['password']);
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = :dbname");
                $stmt->execute(['dbname' => $connection['database']]);
                if ($stmt->fetch()) {
                    echo "Database ".$connection['database']." exists.";
                } else {
                    $pdo->exec("CREATE DATABASE ".$connection['database']);
                    echo "Database ".$connection['database']." created.";
                }

                $this->info('✅  Authentication successful. ');
            } catch (\Exception $e) {
                $this->error("❌  Authentication failed - " . $e->getMessage());
            }
        } else {
            $this->error("❌  Connection failed - $errStr ($errCode)");
        }
    }
}
