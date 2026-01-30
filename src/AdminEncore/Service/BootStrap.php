<?php


namespace Kiwi\Core\AdminEncore\Service;


use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Widgets\Navbar;
use Kiwi\Core\Admin\Service\AdminSite;
use Kiwi\Core\AdminEncore\Extend\Field\MyFile;
use Kiwi\Core\AdminEncore\Extend\Field\MyImage;
use Kiwi\Core\AdminEncore\Extend\Field\MyMultipleFile;
use Kiwi\Core\AdminEncore\Extend\Field\MyMultipleImage;
use Kiwi\Core\AdminEncore\Extend\Filter\BetweenDate;
use Kiwi\Core\AdminEncore\Extend\Form\CKEditor2;

class BootStrap
{
	public static function initGrid(): void
	{
		Grid::init(function (Grid $grid) {
			$grid->disableExport();
			$grid->disableBatchActions();

			$grid->actions(function (Actions $actions) {
				$actions->disableView();
			});
		});

		Grid\Filter::extend("betweenDate", BetweenDate::class);
	}

	public static function initForm(): void
	{
		Form::init(function (Form $form) {
			$form->disableEditingCheck();
			$form->disableCreatingCheck();
			$form->disableViewCheck();

			$form->tools(function (Tools $tools) {
				$tools->disableDelete();
				$tools->disableView();
				$tools->disableList();
			});
		});

		Form::extend('image', MyImage::class);
		Form::extend('multipleImage', MyMultipleImage::class);

		Form::extend('file', MyFile::class);
		Form::extend('multipleFile', MyMultipleFile::class);

//		Form::extend('ckeditor', CKEditor::class);
		Form::extend('ckeditor', CKEditor2::class);
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
