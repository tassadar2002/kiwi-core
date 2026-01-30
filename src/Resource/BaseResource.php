<?php

namespace Kiwi\Core\Resource;


use Carbon\Carbon;
use JsonSerializable;

abstract class BaseResource implements JsonSerializable
{
	/**
	 * The resource instance.
	 *
	 * @var mixed
	 */
	public mixed $model;

	public function __construct($model)
	{
		$this->model = $model;
	}

	/**
	 * Dynamically get properties from the underlying resource.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get(string $key)
	{
		return $this->model->{$key};
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function __isset(string $key)
	{
		return isset($this->model->{$key});
	}

	/**
	 * Dynamically pass method calls to the underlying resource.
	 *
	 * @param string $method
	 * @param array $parameters
	 * @return mixed
	 */
	public function __call(string $method, array $parameters)
	{
		return $this->model->{$method}(...$parameters);
	}

	protected function toTimestamp(Carbon $value): int
	{
		return intval($value->format("U"));
	}

	protected function toDateTime(Carbon $value): string
	{
		return $value->format("Y-m-d H:i:s");
	}
}