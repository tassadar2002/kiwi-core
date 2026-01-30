<?php

namespace Kiwi\Core\AdminDcat\Extend;

class MyForm extends \Dcat\Admin\Form
{
	public function rendering()
	{
		$this->build();

		if ($this->isCreating()) {
			$this->callCreating();

			return;
		}

		// dcat和encore的editing事件调用时机不同，dcat是fillfield之后调用，encore相反。所以dcat没法实现editing中hook并修改model数据
		// 交换以下两行的位置，使得在editing中可以修改model的数据
		// Form::model 下行时还是Model，上行时就变成了Fluent。所以下行时取model时可以直接->model()，不必->repository()->model()
		$this->callEditing();
		$this->fillFields($this->model()->toArray());
	}

	protected static function formatEventKey($key): string
	{
		// fire event时使用了类名，所以需要重写使用Form的原生类名
		return parent::class . ':' . $key;
	}
}