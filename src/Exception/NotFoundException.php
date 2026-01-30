<?php

namespace Kiwi\Core\Exception;

use Exception;

class NotFoundException extends Exception
{
	public function renderJson(): array
	{
		return [
			"code" => 410,
			"message" => "Not Found " . $this->getMessage(),
		];
	}
}