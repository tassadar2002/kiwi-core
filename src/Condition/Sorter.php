<?php

namespace Kiwi\Core\Condition;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait Sorter
{
	public static function sortById(): Closure
	{
		return self::sortByKey("id");
	}

	public static function sortByIdAsc(): Closure
	{
		return self::sortByKeyAsc("id");
	}

	public static function sortByCreatedAt(): Closure
	{
		return self::sortByKey("created_at");
	}

	public static function sortByUpdatedAt(): Closure
	{
		return self::sortByKey("updated_at");
	}

	public static function sortByKey($key): Closure
	{
		return function (Builder $query) use ($key) {
			return $query->orderBy($key, "desc");
		};
	}

	public static function sortByKeyAsc($key): Closure
	{
		return function (Builder $query) use ($key) {
			return $query->orderBy($key, "asc");
		};
	}
}