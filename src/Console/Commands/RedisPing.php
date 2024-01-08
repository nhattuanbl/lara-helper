<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisPing extends Command
{
    protected $signature = 'redis:ping {--C|connection=default} {--T|timeout=2}';

    protected $description = 'Test redis connection and authentication';

    public function handle()
    {
        $timeout = $this->option('timeout');
        $connectionName = $this->option('connection');

        $config = config("database.redis.$connectionName");
        if (!$config) {
            $this->error("Connection [$connectionName] not configured.");
            return;
        }

        $this->output->write("Checking connection to [" . $config['host'] . ":" . $config['port'] . "] on connection [$connectionName]... ");

        if($fp = @fsockopen($config['host'], $config['port'],$errCode,$errStr, $timeout)) {
            fclose($fp);
            $this->info('✅  Connection established.');
            $this->output->write("Checking authentication... ");

            $redis = Redis::connection($connectionName);
            $pingResult = $redis->ping();
            if ($pingResult === "+PONG") {
                $this->info('✅  Authentication successful.');
            } else {
                $this->error("❌  Authentication failed - " . $pingResult);
            }
        } else {
            $this->error("❌  Connection failed - $errStr ($errCode)");
        }
    }
}
