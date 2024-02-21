<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DBCopy extends Command
{
    protected $signature = 'db:copy {table_name} {--S|src_connection_name=babo_reader} {--D|dest_connection_name=mysql}';
    protected $description = 'Copy table structure from one database connection to another.';

    public function handle()
    {
        $tableName = $this->argument('table_name');
        $srcConnectionName = $this->option('src_connection_name') ?: config('database.default');
        $this->info("Copying structure of [{$tableName}] from [{$srcConnectionName}] connection...");

        $destConnectionName = $this->option('dest_connection_name') ?: config('database.default');
        if ($srcConnectionName == $destConnectionName) {
            $this->error("Source and destination connection names are the same.");
            return;
        }

        if (Schema::connection($destConnectionName)->hasTable($tableName)) {
            $this->error("The table {$tableName} already exists in the {$destConnectionName} connection.");
            return;
        }

        $destSchema = \DB::connection($destConnectionName);
        $srcSchema = \DB::connection($srcConnectionName);

        try {
            $createTableSql = $srcSchema->select('SHOW CREATE TABLE ' . $tableName)[0]->{'Create Table'};
            $this->info($createTableSql);
            dump($destSchema->statement($createTableSql));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
