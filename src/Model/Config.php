<?php

namespace Kiwi\Core\Model;

use Carbon\Carbon;

/**
 * Class Config
 * @package Kiwi\Web\Model
 * @property int id
 * @property string name
 * @property string value
 * @property string type
 * @property string description
 * @property Carbon createdAt
 * @property Carbon updatedAt
 */
class Config extends BaseModel
{
	use Site;

	protected $table = "config";

	protected $dates = [
		"created_at",
		"updated_at",
	];

	const TYPE_STRING = "string";
	const TYPE_INT = "int";
	const TYPE_JSON = "json";

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setSiteInfo();
	}
}