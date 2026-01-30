<?php


namespace Kiwi\Core\AdminDcat\Controller;


use Dcat\Admin\Layout\Content;
use Kiwi\Core\AdminDcat\Form\UploadFileForm;

class FileController extends \Kiwi\Core\Admin\Controller\FileController
{
	public function uploadForm(Content $content): Content
	{
		return $content
			->title('上传文件')
			->body(new UploadFileForm());
	}
}
