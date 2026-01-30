<?php


namespace Kiwi\Core\AdminEncore\Controller;


use Encore\Admin\Layout\Content;
use Kiwi\Core\AdminEncore\Form\UploadFileForm;

class FileController extends \Kiwi\Core\Admin\Controller\FileController
{
	public function uploadForm(Content $content): Content
	{
		return $content
			->title('上传文件')
			->body(new UploadFileForm());
	}
}
