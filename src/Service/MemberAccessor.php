<?php

namespace Kiwi\Core\Service;


use Closure;

class MemberAccessor
{
	public function set($obj, $name, $value): void
	{
		$setter = Closure::bind(function & ($obj) use ($name) {
			return $obj->$name;
		}, null, $obj);

		$member = &$setter($obj);
		$member = $value;
	}

	public function get($obj, $name)
	{
		$getter = Closure::bind(function ($obj) use ($name) {
			return $obj->$name;
		}, null, $obj);
		return $getter($obj);
	}
}
