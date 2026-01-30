<?php

namespace Kiwi\Core\Service;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait CheckId
{
	/**
	 * @param $id
	 * @return int
	 * @throws ValidationException
	 */
	protected function checkId($id): int
	{
		$validator = Validator::make(
			["id" => $id],
			["id" => "required|integer|min:1"]
		);
		if ($validator->fails()) {
			throw new ValidationException($validator);
		}
		return intval($id);
	}
}