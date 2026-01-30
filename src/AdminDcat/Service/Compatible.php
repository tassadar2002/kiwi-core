<?php

namespace Kiwi\Core\AdminDcat\Service;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Tree;
use Illuminate\Database\Eloquent\Model;
use Kiwi\Core\AdminDcat\Action\Import;
use Kiwi\Core\AdminDcat\Extend\MyForm;

trait Compatible
{
	public function createGrid($model): Grid
	{
		return new Grid($model);
	}

	public function createForm($model, ?array $relations = null): Form
	{
		if (empty($relations)) {
			return new MyForm($model);
		} else {
			return new MyForm($model->with($relations));
		}
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
		return $self->id;
	}

	public function addAction(Actions $actions, RowAction $action): void
	{
		$actions->append($action);
	}

	public function formModel(Form $form, bool $refresh = false): Model
	{
		$model = $form->repository()->model();
		if ($refresh && $model instanceof Model) {
			// dcat, saved中还会指向原来的relation，id没有变化，需要手动刷新
			$model->refresh();
		}
		return $model;
	}

	public function formInputArray(Form $form, string $column): array
	{
		return Helper::array($form->input($column));
	}

	public function createImport(string $type, string $title = ""): Import
	{
		return new Import($type, $title);
	}

	public function disableFooterOnEdit(Form $form): void
	{
		$form->editing(function () use ($form) {
			$form->disableFooter();
		});
	}

	/**
	 * editing中修改了mode值，需要手动fill才能填充到Field中，和encore不同
	 * @param string $column
	 * @param Form $form
	 * @return void
	 */
	public function refillField(string $column, Form $form): void
	{
		$form->field($column)->fill($form->model()->toArray());
	}

	/**
	 * editing中修改了mode值，需要手动fill才能填充到Field中，和encore不同
	 * @param Form $form
	 * @return void
	 */
	public function refillFields(Form $form): void
	{
		$form->fillFields($form->model()->toArray());
	}
}