<?php

namespace Kiwi\Core\AdminEncore\Extend\Field;

use Kiwi\Core\Admin\Extend\Field\MyUploadField;

trait EncoreUploadFile
{
	use MyUploadField;

	public function __construct($column, $arguments = [])
	{
		parent::__construct($column, $arguments);
		$this->retainable();
	}
}