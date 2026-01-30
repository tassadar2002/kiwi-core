<?php

namespace Kiwi\Core\AdminEncore\Extend\Form;

use Encore\Admin\Form\Field\Textarea;

class CKEditor2 extends Textarea
{
	public static $js = [
		'/vendor/laravel-admin-ext/ckeditor/ckeditor.js',
	];

	protected $view = 'kiwi::admin.encore.ckeditor2';

	public function render()
	{
		$config = (array)config("admin.extensions.ckeditor.config");

		$config = json_encode(array_merge($config, $this->options));

		$this->script = <<<EOT
CKEDITOR.replace('{$this->id}', $config);
EOT;

		return parent::render();
	}
}