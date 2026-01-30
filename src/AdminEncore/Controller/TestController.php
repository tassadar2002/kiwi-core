<?php

namespace Kiwi\Core\AdminEncore\Controller;


use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class TestController extends AdminController
{
	public function index(Content $content)
	{
		return $content
			->header('Modal')
			->description('模态窗')
			->body($this->render());
	}

	protected function render()
	{
		return "";
	}
}