<?php

namespace Kiwi\Core\AdminEncore\Extend\Form;

use Encore\Admin\Form\Field;

class CKEditor extends Field
{
	public static $js = [
		'/vendor/laravel-admin-ext/ckeditor/ckeditor.js',
		'/vendor/laravel-admin-ext/ckeditor/adapters/jquery.js',
	];

	protected $view = 'kiwi::admin.encore.ckeditor';

	public function render()
	{
		$this->script = "$('textarea.{$this->getElementClassString()}').ckeditor();";

		return parent::render();
	}
}