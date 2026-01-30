<?php

namespace Kiwi\Core\Admin\Controller;

use Kiwi\Core\Admin\Model\Element;

trait ElementController
{
	public function __construct()
	{
		$this->title = "Element";
	}

	protected function grid(): \Dcat\Admin\Grid|\Encore\Admin\Grid
	{
		$grid = $this->createGrid(new Element());

		$grid->column('id', __('Id'));
		$grid->column('name', __('Name'));
		$grid->column('parent', __('Parent'));
		$grid->column('title', __('Title'));
		$grid->column('subtitle', __('Subtitle'));
		$grid->column('image', __('Image'))->image('', 100, 100);
		$grid->column('attribute', __('Attribute'));
		$grid->column('link', __('Link'));
		$grid->column('order', __('Order'));
		$grid->column('created_at', __('Created at'));
		$grid->column('updated_at', __('Updated at'));

		$grid->tools(function (\Dcat\Admin\Grid\Tools|\Encore\Admin\Grid\Tools $tools) {
			$tools->append($this->createImport("element"));
		});

		return $grid;
	}

	protected function form(): \Dcat\Admin\Form|\Encore\Admin\Form
	{
		$form = $this->createForm(new Element());

		$form->text('name', __('Name'))->default("");
		$form->text('parent', __('Parent'))->default("");
		$form->text('title', __('Title'))->default("");
		$form->text('subtitle', __('Subtitle'))->default("");
		$form->image('image', __('Image'))->type("images")->default("");
		$form->text('attribute', __('Attribute'))->default("");
		$form->url('link', __('Link'))->default("");
		$form->number('order', __('Order'))->default(0);

		return $form;
	}
}
