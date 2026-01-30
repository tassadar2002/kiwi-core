<?php

namespace Kiwi\Core\Condition;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait Pager
{
	public static function pagerById($cursor, $count): Closure
	{
		return function (Builder $query) use ($cursor, $count) {
			if ($cursor !== 0) {
				$query = $query->where("id", "<", $cursor);
			}
			return $query->take($count);
		};
	}

	public static function pagerBySequence($start, $length): Closure
	{
		return function (Builder $query) use ($start, $length) {
			return $query
				->skip($start)
				->take($length);
		};
	}
}