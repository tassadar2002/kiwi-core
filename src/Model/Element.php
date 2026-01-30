<?php


namespace Kiwi\Core\Model;


use Carbon\Carbon;

/**
 * Class Element
 * @package Kiwi\Core\Model
 * @property int id
 * @property string name
 * @property string parent
 * @property string title
 * @property string subtitle
 * @property string image
 * @property string attribute
 * @property string link
 * @property int order
 * @property Carbon createdAt
 * @property Carbon updatedAt
 */
class Element extends BaseModel
{
	use Site;

	protected $table = "element";

	protected $dates = [
		"created_at",
		"updated_at",
	];

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setSiteInfo();
	}
}