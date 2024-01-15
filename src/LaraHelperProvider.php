<?php

namespace Nhattuanbl\LaraHelper;

use Illuminate\Support\ServiceProvider;
use Nhattuanbl\LaraHelper\Console\Commands\CheckExt;
use Nhattuanbl\LaraHelper\Console\Commands\ElasticPing;
use Nhattuanbl\LaraHelper\Console\Commands\MongoPing;
use Nhattuanbl\LaraHelper\Console\Commands\MysqlPing;
use Nhattuanbl\LaraHelper\Console\Commands\RedisPing;

class LaraHelperProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->commands([
            ElasticPing::class,
            MongoPing::class,
            MysqlPing::class,
            RedisPing::class,
            CheckExt::class,
        ]);
    }
}
