<?php

namespace Kiwi\Core\AdminDcat\Form;


use Dcat\Admin\Widgets\Form;
use Kiwi\Core\Admin\Service\ImportService;

class ImportForm extends Form
{
	public string $type = "";

	public function handle(array $input)
	{
		$fileName = storage_path("app") . $input["file"];
		$type = $input["type"];

		/** @var ImportService $service */
		$service = app(ImportService::class);
		$service->import($fileName, $type);

		return $this->response()->success('Success')->refresh();
	}

	public function form()
	{
		$this->file('file', "")->disk('local')->required();
		$this->hidden("type")->value($this->type);
	}
}