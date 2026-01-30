<?php


namespace Kiwi\Core\AdminDcat\Service;


use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Navbar;
use Kiwi\Core\Admin\Service\AdminSite;
use Kiwi\Core\AdminDcat\Extend\Field\MyFile;
use Kiwi\Core\AdminDcat\Extend\Field\MyImage;
use Kiwi\Core\AdminDcat\Extend\Field\MyMultipleFile;
use Kiwi\Core\AdminDcat\Extend\Field\MyMultipleImage;
use Kiwi\Core\AdminDcat\Extend\Filter\BetweenDate;
use Kiwi\Core\AdminDcat\Extend\Form\CKEditor;

class BootStrap
{
	public static function initGrid(): void
	{
		Grid::resolving(function (Grid $grid) {
			$grid->disableViewButton();
			$grid->disableRowSelector();
			$grid->showColumnSelector();
//			$grid->toolsWithOutline(false);
		});

		Grid\Filter::extend("betweenDate", BetweenDate::class);
	}

	public static function initForm(): void
	{
		Form::resolving(function (Form $form) {
			$form->disableEditingCheck();
			$form->disableCreatingCheck();
			$form->disableViewCheck();

			$form->disableHeader();
//			$form->disableListButton();
//			$form->disableViewButton();
//			$form->disableDeleteButton();
		});

		Form::extend('image', MyImage::class);
		Form::extend('multipleImage', MyMultipleImage::class);

		Form::extend('file', MyFile::class);
		Form::extend('multipleFile', MyMultipleFile::class);

		CKEditor::boot();
		Form::extend('ckeditor', CKEditor::class);
//		Form::extend('ckeditor', CKEditor2::class);
	}

	public static function initNavBar(): void
	{
		Admin::navbar(function (Navbar $navBar) {
			if (self::adminSiteService()->isEnable()) {
				$service = app(AdminSite::class);
				/** @var AdminSite $service */

				$navBar->left($service->renderMenu());
			}
		});
	}

	public static function handleMultiSite(): void
	{
		self::adminSiteService()->configCurrent();
	}

	private static function adminSiteService(): AdminSite
	{
		return app(AdminSite::class);
	}
}
