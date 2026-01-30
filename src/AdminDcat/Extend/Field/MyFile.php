<?php


namespace Kiwi\Core\AdminDcat\Extend\Field;


use Dcat\Admin\Form\Field\File;

class MyFile extends File
{
	use DcatUploadFile;

	/**
	 * @var string
	 * 默认查找的模板是 $class = explode('\\', static::class), 所以需要指明
	 */
	protected $view = 'admin::form.file';
}