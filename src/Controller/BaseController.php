<?php

namespace Kiwi\Core\Controller;


use Illuminate\Routing\Controller;
use Kiwi\Core\Resource\BaseResource;

class BaseController extends Controller
{
	/**
	 * @param int $status
	 * @param string|null $message
	 * @param array|BaseResource|null $data
	 * @return array
	 */
	public function renderApi(int $status, ?string $message = null, array|BaseResource|null $data = null): array
	{
		$result = ["status" => $status];
		if (!empty($message)) {
			$result["message"] = $message;
		}
		if (!is_null($data)) {
			$result["data"] = $data;
		}
		return $result;
	}

	/**
	 * @param array|BaseResource|null $data
	 * @return array
	 */
	public function renderSuccessApi(array|BaseResource|null $data = null): array
	{
		return $this->renderApi(0, null, $data);
	}
}
