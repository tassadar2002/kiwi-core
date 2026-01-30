<?php

namespace Kiwi\Core\Exception;

use Exception;

/**
 * Class ArgumentException 自定义参数异常
 * @package App\Exception
 */
class ArgumentException extends Exception
{
	public function renderJson(): array
	{
		return [
			"code" => 422,
			"message" => $this->getMessage(),
		];
	}
}