<?php

namespace Kiwi\Core\Resource;

use Illuminate\Support\Collection;
use JsonSerializable;
use ReflectionClass;

class CollectionResource implements JsonSerializable
{
	use FormatResource;

	protected Collection $models;

	protected string $resourceClass;

	public function __construct(Collection $models, $resourceClass)
	{
		$this->models = $models;
		$this->resourceClass = $resourceClass;
	}

	function jsonSerialize()
	{
		$arr = [];
		foreach ($this->models as $model) {
			$resource =
				(new ReflectionClass($this->resourceClass))->newInstance($model);
			if (method_exists($resource, "withFormat")) {
				$resource->withFormat($this->format);
			}
			$arr[] = $resource;
		}
		return collect($arr);
	}
}