<?php

namespace Kiwi\Core\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use jdavidbakr\ReplaceableModel\ReplaceableModel;

class BaseModel extends Model
{
	use ReplaceableModel;

	public $timestamps = false;
	public $guarded = [];

	/**
	 * 支持camel和snake两种获取方法
	 * 数据库为snake字段命名
	 * @param string $key
	 * @return mixed
	 */
	public function getAttribute($key): mixed
	{
		$snakeKey = Str::snake($key);
		// avoid relationship attribute, eg "channelModel"
		if (array_key_exists($snakeKey, $this->attributes)) {
			return parent::getAttribute($snakeKey);
		} else {
			return parent::getAttribute($key);
		}
	}

	/**
	 * 支持camel和snake两种设置方法
	 * @param string $key
	 * @param mixed $value
	 * @return mixed
	 */
	public function setAttribute($key, $value): mixed
	{
		$snakeKey = Str::snake($key);
		if ($snakeKey !== $key && !Str::endsWith($key, "Model")) {
			return parent::setAttribute($snakeKey, $value);
		} else {
			return parent::setAttribute($key, $value);
		}
	}
}