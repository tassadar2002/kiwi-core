<?php


namespace Kiwi\Core\Admin\Controller;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kiwi\Core\Exception\AppException;
use Kiwi\Core\Exception\ArgumentException;
use Kiwi\Core\Service\FileService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileController extends Controller
{
	private FileService $service;

	public function __construct(FileService $service)
	{
		$this->service = $service;
	}

	/**
	 * @param Request $request
	 * @return string
	 */
	public function ckeditor(Request $request): string
	{
		$url = "";
		$message = "";
		try {
			$url = $this->upload_($request, "article");
		} catch (Exception $e) {
			$message = $e->getMessage();
		}

		$CKEditorFuncNum = request("CKEditorFuncNum");

		return "<script>window.parent.CKEDITOR.tools.callFunction({$CKEditorFuncNum},'{$url}','{$message}');</script>";
	}

	/**
	 * @param Request $request
	 * @param string $type
	 * @param string $name
	 * @return mixed
	 * @throws AppException
	 * @throws ArgumentException
	 */
	public function upload_(Request $request, string $type = "default", string $name = ""): string
	{
		if ($request->files->count() === 0) {
			throw new ArgumentException("upload fail. upload file not found");
		}

		$file = $request->files->get($request->files->keys()[0]);
		if (!$file) {
			throw new ArgumentException("upload fail. upload file not found");
		}
		/** @var UploadedFile $file */

		return $this->service->uploadByFullName(
			$file->getRealPath(),
			$file->getClientOriginalExtension(),
			$type);
	}
}
