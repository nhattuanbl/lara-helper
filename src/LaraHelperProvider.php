<?php

namespace Nhattuanbl\LaraHelper;

use Illuminate\Support\ServiceProvider;
use Nhattuanbl\LaraHelper\Console\Commands\ElasticPing;
use Nhattuanbl\LaraHelper\Console\Commands\MongoPing;

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
        ]);
    }
}
