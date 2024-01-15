<?php

namespace Nhattuanbl\LaraHelper\Console\Commands;

use Illuminate\Console\Command;

class CheckExt extends Command
{
    protected $signature = 'check:ext {extensions*}';

    protected $description = 'Check if the given PHP extensions are installed';

    public function handle()
    {
        $extensions = $this->argument('extensions');
        foreach ($extensions as $extension) {
            if (extension_loaded($extension)) {
                $this->info("✅  Extension '{$extension}' is installed.");
            } else {
                $this->error("❌  Extension '{$extension}' is NOT installed.");
            }
        }
    }
}
