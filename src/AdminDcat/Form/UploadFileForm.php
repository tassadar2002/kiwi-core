<?php

namespace Kiwi\Core\AdminDcat\Form;


use Dcat\Admin\Widgets\Form;
use Kiwi\Core\Exception\AppException;
use Kiwi\Core\Service\FileService;

class UploadFileForm extends Form
{
	public function handle(array $input)
	{
		$fileName = storage_path("app") . $input["file"];
		$type = $input["type"];

		$pathInfo = pathinfo($fileName);
		$ext = $pathInfo["extension"];

		try {
			$url = $this->service()->uploadByFullName($fileName, $ext, $type);
			return $this->response()->alert()->detail($url)->success('Success')->refresh();
		} catch (AppException $e) {
			return $this->response()->error($e->getMessage());
		}
		// 这里 admin_success 和 admin_error 无效，改为 alert
	}

	public function form()
	{
		$this->file('file')->disk('local')->required();
		$this->text('type')->required();
	}

	private function service(): FileService
	{
		return app(FileService::class);
	}
}