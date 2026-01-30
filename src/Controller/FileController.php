<?php


namespace Kiwi\Core\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kiwi\Core\Exception\AppException;
use Kiwi\Core\Exception\ArgumentException;
use Kiwi\Core\Service\FileService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileController extends BaseController
{
	private FileService $service;

	public function __construct(FileService $service)
	{
		$this->service = $service;
	}

	/**
	 * @param Request $request
	 * @param string $type
	 * @param string $name
	 * @return array
	 * @throws ArgumentException
	 */
	public function upload(Request $request, string $type = "default", string $name = ""): array
	{
		if ($request->files->count() === 0) {
			throw new ArgumentException("upload fail. upload file not found");
		}

		$file = $request->files->get($request->files->keys()[0]);
		if (!$file) {
			throw new ArgumentException("upload fail. upload file not found");
		}
		/** @var UploadedFile $file */

		try {
			$url = $this->service->uploadByFullName(
				$file->getRealPath(),
				$file->getClientOriginalExtension(),
				$type);
		} catch (AppException $e) {
			Log::error($e->getMessage());
			return [];
		}
		return ["url" => $url];
	}
}