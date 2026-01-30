<?php


namespace Kiwi\Core\AdminDcat\Action;


use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Widgets\Modal;
use Kiwi\Core\AdminDcat\Form\ImportForm;

class Import extends AbstractTool
{
	protected string $type = "";

	public function __construct(string $type = "", string $title = "")
	{
		parent::__construct(empty($title) ? "Import" : $title);
		$this->type = $type;
	}

	public function render()
	{
		$form = ImportForm::make();
		$form->type = $this->type;

		return Modal::make()
			->lg()
			->title($this->title)
			->body($form)
			->button("<button class='btn btn-primary btn-outline'><i class='fa fa-upload'></i>&nbsp;$this->title</button>");
	}
}