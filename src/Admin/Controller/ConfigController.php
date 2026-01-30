<?php

namespace Kiwi\Core\Admin\Controller;

use Kiwi\Core\Admin\Model\Config;

trait ConfigController
{
	public function __construct()
	{
		$this->title = "Config";
	}

	protected function grid(): \Dcat\Admin\Grid|\Encore\Admin\Grid
	{
		$grid = $this->createGrid(new Config());

		$grid->column('id', __('Id'));
		$grid->column('name', __('Name'));
		$grid->column('type', __('Type'))->using(Config::displayType());
		$grid->column('value', __('Value'))->limit(200);
		$grid->column('description', __('Description'));
		$grid->column('created_at', __('Created at'));
		$grid->column('updated_at', __('Updated at'));

		return $grid;
	}

	protected function form(): \Dcat\Admin\Form|\Encore\Admin\Form
	{
		$form = $this->createForm(new Config());

		$form->text('name', __('Name'))->required();
		$form->select('type', __('Type'))->options(Config::displayType())->required();
		$form->textarea('value', __('Value'))->required();
		$form->textarea('description', __('Description'));

		return $form;
	}
}
