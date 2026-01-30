<?php

namespace Kiwi\Core\Exception;

use Exception;

/**
 * Class AppException 服务器内部异常
 * @package App\Exception
 */
class AppException extends Exception
{
	public function renderJson(): array
	{
		return [
			"code" => 500,
			"message" => "Server Error",
		];
	}
}