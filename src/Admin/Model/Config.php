<?php


namespace Kiwi\Core\Admin\Model;


use Kiwi\Core\Admin\Service\DefaultDatetimeFormat;

class Config extends \Kiwi\Core\Model\Config
{
	use DefaultDatetimeFormat;

	public static function displayType(): array
	{
		return [
			self::TYPE_STRING => "string",
			self::TYPE_INT => "int",
			self::TYPE_JSON => "json",
		];
	}
}
