<?php

namespace Nhattuanbl\LaraHelper\Helpers;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Query\Builder;

class SqlHelper
{
    /**
     * @param MorphToMany|MorphTo|Builder|\Illuminate\Database\Eloquent\Builder|HasMany|HasOne|BelongsTo $builder
     */
    public static function debug($builder): string
    {
        return vsprintf(str_replace('?', '%s', $builder->toSql()), collect($builder->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
}
