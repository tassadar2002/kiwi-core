<?php

namespace Kiwi\Core\Admin\Controller;

use Illuminate\Support\Facades\Hash;
use Kiwi\Core\Admin\Service\AdminUser;

trait AdminUserController
{
	public function __construct()
	{
		$this->title = "AdminUser";
	}


	protected function grid(): \Encore\Admin\Grid|\Dcat\Admin\Grid
	{
		$grid = $this->createGrid(new AdminUser());

		$grid->column('id', __('Id'));
		$grid->column('email', __('Email'));
		$grid->column('description', __('Description'));
		$grid->column('role', __('Role'));
		$grid->column('created_at', __('Created at'));
		$grid->column('updated_at', __('Updated at'));

		$grid->actions(function ($actions) {
			$actions->disableView();
			$actions->disableDelete();
		});

		return $grid;
	}

	protected function form(): \Encore\Admin\Form|\Dcat\Admin\Form
	{
		$form = $this->createForm(new AdminUser());

		$form->text('email', __('Email'));
		$form->text('description', __('Description'));
		$form->password('password', __('Password'));
		$form->text('role');

		$form->saving(function (\Encore\Admin\Form|\Dcat\Admin\Form $form) {
			$password = $form->input("password");
			$form->input("password", Hash::make($password));
		});

		return $form;
	}
}
