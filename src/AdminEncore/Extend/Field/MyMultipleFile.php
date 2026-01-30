<?php


namespace Kiwi\Core\AdminEncore\Extend\Field;


use Encore\Admin\Form\Field\MultipleFile;

class MyMultipleFile extends MultipleFile
{
	use EncoreUploadFile;

	/**
	 * @var string
	 */
	protected $view = 'admin::form.multiplefile';
}