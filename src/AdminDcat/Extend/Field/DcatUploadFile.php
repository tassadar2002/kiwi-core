<?php

namespace Kiwi\Core\AdminDcat\Extend\Field;

use Kiwi\Core\Admin\Extend\Field\MyUploadField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait DcatUploadFile
{
	use MyUploadField {
		upload as myUpload;
	}

	public function __construct($column, $arguments = [])
	{
		parent::__construct($column, $arguments);
		$this
			->autoUpload()    // 没有上传按钮，自动上传
			->retainable()    // 不删除oss的文件
			->removable(false)    // 网页点击删除不向服务器发送请求
			->autoSave(false);    // 上传文件后不自动保存到数据库autoUpdateColumn
	}

	/**
	 * override默认的upload，因为返回值类型不同，dcat返回JsonResponse
	 * @param UploadedFile $file
	 * @return mixed
	 */
	public function upload(UploadedFile $file)
	{
		$path = $this->myUpload($file);
		if (is_string($path)) {
			$url = $this->objectUrl($path);
			return $this->responseUploaded($this->saveFullUrl ? $url : $path, $url);
		}
		return $path;
	}

	/**
	 * overrider默认的 $this->storage, 因为有可能 $this->storage 此时为 null
	 * @param string $path
	 * @return bool
	 */
	protected function exists(string $path): bool
	{
		return $this->getStorage()->exists($path);
	}
}