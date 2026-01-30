<?php

namespace Kiwi\Core\Condition;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait Selector
{
    public static function selectId(): Closure
    {
        return function (Builder $query) {
            return $query->select("id");
        };
    }

    public static function builder(): Closure
    {
        return function (Builder $query) {
            return $query;
        };
    }
}