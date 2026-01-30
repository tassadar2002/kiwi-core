<?php


namespace Kiwi\Core\AdminDcat\Extend\Field;


use Dcat\Admin\Form\Field\MultipleFile;
use Kiwi\Core\Admin\Extend\Field\MyUploadField;

class MyMultipleFile extends MultipleFile
{
	use DcatUploadFile;

	/**
	 * @var string
	 */
	protected $view = 'admin::form.multiplefile';
}