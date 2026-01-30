<?php


namespace Kiwi\Core\AdminEncore\Extend;


use Encore\Admin\Layout\Content;

/**
 * 全屏控件
 * 用法：在Controller里use FullContent即可
 */
trait FullContent
{
	public function index(Content $content)
	{
		return parent::index(app(MyContent::class));
	}

	public function edit($id, Content $content)
	{
		return parent::edit($id, app(MyContent::class));
	}

	public function create(Content $content)
	{
		return parent::create(app(MyContent::class));
	}
}
