<?php


namespace Kiwi\Core\Admin\Extend\Field;


use Closure;
use Kiwi\Core\Service\FileService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait MyUploadField
{
	/**
	 * @var string 保存的文件夹名
	 */
	protected string $type;

	/**
	 * @var array|callable 上传时的选项
	 */
	protected $uploadOptions;

	/**
	 * @param string $type
	 * @return $this
	 */
	public function type(string $type): static
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @param array|callable $callback
	 */
	public function uploadOptions(array|callable $callback): void
	{
		$this->uploadOptions = $callback;
	}

	public function upload(UploadedFile $file): mixed
	{
		$path = $this->fileService()->getStorePathByFullName(
			$file->getRealPath(),
			$file->getClientOriginalExtension(),
			$this->type);

		// 已经存在, 直接返回
		if ($this->exists($path)) {
			return $path;
		}

		$paths = pathinfo($path);
		$this->directory = $paths["dirname"];
		$this->name = $paths["basename"];

		$this->handleUploadOptions($file);

		return parent::upload($file);
	}

	protected function exists(string $path): bool
	{
		return $this->storage->exists($path);
	}

	protected function uploadAndDeleteOriginal(UploadedFile $file): string
	{
		$path = $this->upload($file);
		$this->destroy();
		return $path;
	}

	/**
	 * 设置上传选项
	 * parent中如果storagePermission不为null, 则把它传到options参数中
	 * 在filesystem中判断如果是string则处理为 [visibility=>storagePermission], 否则直接使用
	 * 这里就直接修改为array, 使filesystem直接使用
	 * @param UploadedFile $file
	 */
	private function handleUploadOptions(UploadedFile $file): void
	{
		if (empty($this->uploadOptions)) {
			return;
		}

		if (!is_null($this->storagePermission)) {
			$this->storagePermission = ["visibility" => $this->storagePermission];
		} else {
			$this->storagePermission = [];
		}

		if (is_array($this->uploadOptions)) {
			$this->storagePermission += $this->uploadOptions;
		}
		if ($this->uploadOptions instanceof Closure) {
			$this->storagePermission += $this->uploadOptions->call($this, $file);
		}
	}

	private function fileService(): FileService
	{
		return app(FileService::class);
	}
}
