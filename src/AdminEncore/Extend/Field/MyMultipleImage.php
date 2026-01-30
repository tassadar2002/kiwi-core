<?php


namespace Kiwi\Core\AdminEncore\Extend\Field;


use Encore\Admin\Form\Field\MultipleImage;

class MyMultipleImage extends MultipleImage
{
	use EncoreUploadFile;

	// 解决bug
	protected $rules = '';
}
