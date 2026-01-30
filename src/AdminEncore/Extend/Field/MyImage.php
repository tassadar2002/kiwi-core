<?php


namespace Kiwi\Core\AdminEncore\Extend\Field;


use Encore\Admin\Form\Field\Image;

class MyImage extends Image
{
	use EncoreUploadFile;

	public function prepare($image): string
	{
		// 已经上传完成的string, 赋值在 Image 控件里
		if (is_string($image)) {
			return $image;
		}
		return parent::prepare($image);
	}
}
