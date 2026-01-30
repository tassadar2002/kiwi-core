<?php

namespace Kiwi\Core\AdminEncore\Form;


use Encore\Admin\Widgets\Form;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kiwi\Core\Exception\AppException;
use Kiwi\Core\Service\FileService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileForm extends Form
{
	/**
	 * The form title.
	 *
	 * @var  string
	 */
	public $title = 'UploadFile';

	/**
	 * Handle the form request.
	 *
	 * @param Request $request
	 *
	 * @return  RedirectResponse
	 */
	public function handle(Request $request): RedirectResponse
	{
		if ($request->files->count() === 0) {
			admin_error("upload fail. upload file not found");
			return back();
		}

		$file = $request->files->get($request->files->keys()[0]);
		if (!$file) {
			admin_error("upload fail. upload file not found");
			return back();
		}
		/** @var UploadedFile $file */

		try {
			$url = $this->service()->uploadByFullName(
				$file->getRealPath(),
				$file->getClientOriginalExtension(),
				$request->input("type"));
			admin_success("Processed successfully. $url");
		} catch (AppException $e) {
			admin_error($e->getMessage());
		}
		return back();
	}

	/**
	 * Build a form here.
	 */
	public function form()
	{
		$this->file('file')->required();
		$this->text('type')->required();
	}

	/**
	 * The data of the form.
	 *
	 * @return  array $data
	 */
	public function data(): array
	{
		return [];
	}

	private function service(): FileService
	{
		return app(FileService::class);
	}
}