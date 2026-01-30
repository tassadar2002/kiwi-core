<?php


namespace Kiwi\Core\AdminDcat\Extend\Field;


use Dcat\Admin\Form\Field\MultipleImage;

class MyMultipleImage extends MultipleImage
{
	use DcatUploadFile;

	// 解决bug
	protected $rules = '';
}
