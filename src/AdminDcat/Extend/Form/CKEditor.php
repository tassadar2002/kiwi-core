<?php

namespace Kiwi\Core\AdminDcat\Extend\Form;

use Dcat\Admin\Admin;
use Dcat\Admin\Form\Field;

class CKEditor extends Field
{
	protected $view = 'kiwi::admin.dcat.ckeditor';

	public static function boot()
	{
		Admin::asset()->alias('@ckeditor', [
			'js' => [
				'/vendor/dcat-admin-extensions/ckeditor/ckeditor.js',
				'/vendor/dcat-admin-extensions/ckeditor/adapters/jquery.js',
			],
		]);
	}
}
