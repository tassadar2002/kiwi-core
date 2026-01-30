<?php

namespace Kiwi\Core\AdminDcat\Controller;

use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Modal;
use Kiwi\Core\AdminDcat\Form\ImportForm;

class TestController extends AdminController
{
	public function index(Content $content)
	{
		return $content
			->header('Modal')
			->description('模态窗')
			->body($this->render());
	}

	// 异步加载弹窗内容
	protected function modal3()
	{
		return Modal::make()
			->lg()
			->title('异步加载 - 表单')
			->body(ImportForm::make())
			->button('<button class="btn btn-white btn-outline"><i class="feather icon-edit"></i> 异步加载</button>');
	}


	protected function render()
	{
		return <<<HTML
<div class="btn-group">
{$this->modal3()}
</div>
HTML;
	}
}