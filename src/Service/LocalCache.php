<?php

namespace Kiwi\Core\Service;


use Closure;
use Illuminate\Support\Facades\Cache;

class LocalCache
{
	public function put(string $key, $value, ?int $expiredIn = null): void
	{
		if (EnvChecker::isWeb()) {
			Cache::put($this->key($key), $value, $this->expiredIn($expiredIn));
		}
	}

	public function get(string $key, Closure $getter, ?int $expiredIn = null)
	{
		if (EnvChecker::isWeb()) {
			return Cache::remember(
				$this->key($key),
				$this->expiredIn($expiredIn),
				$getter);
		}
		return $getter();
	}

	public function remove($key): void
	{
		if (EnvChecker::isWeb()) {
			Cache::forget($this->key($key));
		}
	}

	protected function expiredIn(?int $value)
	{
		return empty($value) ? config("kiwi.global_cache_time") : $value;
	}

	protected function key($key)
	{
		return $key;
	}
}