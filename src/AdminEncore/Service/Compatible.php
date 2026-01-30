<?php

namespace Kiwi\Core\AdminEncore\Service;

use Encore\Admin\Actions\RowAction;
use Encore\Admin\Form;
use Encore\Admin\Form\Footer;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\DropdownActions;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use Illuminate\Database\Eloquent\Model;
use Kiwi\Core\AdminEncore\Action\Import;

trait Compatible
{
	public function createGrid($model): Grid
	{
		return new Grid($model);
	}

	public function createForm($model, ?array $relations = null): Form
	{
		return new Form($model);
	}

	public function createShow($model): Show
	{
		return new Show($model);
	}

	public function createTree($model): Tree
	{
		return new Tree($model);
	}

	public function rowIdInColumn($value, $self): int
	{
		return $value->id;
	}

	public function addAction(DropdownActions $actions, RowAction $action): void
	{
		$actions->add($action);
	}

	public function formModel(Form $form, bool $refresh = false): Model
	{
		return $form->model();
	}

	public function formInputArray(Form $form, string $column): array
	{
		return $form->input($column);
	}

	public function createImport(string $type, string $title = ""): Import
	{
		return new Import($type, $title);
	}

	public function disableFooterOnEdit(Form $form): void
	{
		$form->footer(function (Footer $footer) use ($form) {
			if ($form->isEditing()) {
				$footer->disableSubmit();
				$footer->disableReset();
			}
		});
	}
}