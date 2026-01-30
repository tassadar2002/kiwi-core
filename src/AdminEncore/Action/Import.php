<?php


namespace Kiwi\Core\AdminEncore\Action;


use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Kiwi\Core\Admin\Service\ImportService;

class Import extends Action
{
	/**
	 * @var string
	 */
	protected string $type;

	public function __construct(string $type = "", string $title = "")
	{
		parent::__construct();
		$this->type = $type;

		$this->name = empty($title) ? "Import" : $title;
		$this->selector = ".import-post";
	}

	public function handle(Request $request)
	{
		$fileName = $request->file('file');
		$type = $request->input("type");

		/** @var ImportService $service */
		$service = app(ImportService::class);
		$service->import($fileName, $type);

		return $this->response()->success('Success')->refresh();
	}

	public function form(): void
	{
		$this->file('file', "")->required();
		$this->hidden("type")->value($this->type);
	}

	public function html(): string
	{
		return <<<HTML
        <a class="btn btn-sm btn-twitter import-post"><i class="fa fa-upload"></i>$this->name</a>
HTML;
	}
}