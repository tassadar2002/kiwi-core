<?php


namespace Kiwi\Core\AdminEncore\Service;


use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Collection;
use Kiwi\Core\Service\MemberAccessor;

class FieldAccessor
{
	private MemberAccessor $memberAccessor;

	public function __construct(MemberAccessor $memberAccessor)
	{
		$this->memberAccessor = $memberAccessor;
	}

	public function moveGridLastTo(Grid $grid, int $index): void
	{
		$columns = $this->memberAccessor->get($grid, "columns");
		/** @var Collection $columns */

		$self = $columns->last();    // last控件
		$columns->splice(-1);        // 删除last控件
		$columns->splice($index, 0, [$self]);    // 插入到第$index的位置

		$this->memberAccessor->set($grid, "columns", $columns);
	}

	public function hiddenGrid(Grid $grid, int $index): void
	{
		$columns = $this->memberAccessor->get($grid, "columns");
		/** @var Collection $columns */

		$columns->get($index)->hide();
//		$this->memberAccessor->set($grid, "columns", $columns);
	}

	/**
	 * @param Form $form
	 * @param int $index 要移动到的位置
	 */
	public function moveFormLastTo(Form $form, int $index): void
	{
		$current = $this->memberAccessor->get($form->getLayout(), "current");
		$fields = $this->memberAccessor->get($current, "fields");
		/** @var Collection $fields */

		$self = $fields->last();    // last控件
		$fields->splice(-1);        // 删除last控件
		$fields->splice($index, 0, [$self]);    // 插入到第$index的位置

		$this->memberAccessor->set($current, "field", $fields);
	}

	public function hiddenForm(Form $form, int $index): void
	{
		$current = $this->memberAccessor->get($form->getLayout(), "current");
		$fields = $this->memberAccessor->get($current, "fields");
		/** @var Collection $fields */

		$fields->get($index)->setDisplay(false);
//		$this->memberAccessor->set($current, "field", $fields);
	}
}