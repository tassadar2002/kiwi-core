<?php

namespace Kiwi\Core\Provider;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Kiwi\Core\Admin\Service\AdminAuth;
use Kiwi\Core\Admin\Service\AdminMenu;
use Kiwi\Core\Admin\Service\AdminRoute;
use Kiwi\Core\Admin\Service\ElementImporter;
use Kiwi\Core\Admin\Service\Route;
use Kiwi\Core\AdminDcat\Service\MyDcatApplication;
use Kiwi\Core\AdminDcat\Service\MyDcatExtendManager;
use Kiwi\Core\Command\NewAdminUser;
use Kiwi\Core\Service\EnvChecker;
use Kiwi\Core\Service\ImageLinkFormat;

class KiwiServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->publishConfig();
		if (EnvChecker::isAdmin()) {
			$this->registerAdmin();
		}
	}

	public function boot()
	{
		$this->bootTools();
		$this->bootView();
		$this->registerCommand();
		if (EnvChecker::isWeb()) {
			$this->bootWeb();
		}
		if (EnvChecker::isAdmin()) {
			$this->bootAdmin();
		}
		if (EnvChecker::isApi()) {
			$this->bootApi();
		}
	}

	private function registerAdmin()
	{
		if (EnvChecker::isAdmin()) {
			$this->app->singleton('admin.app', MyDcatApplication::class);
			$this->app->singleton('admin.extend', MyDcatExtendManager::class);
			$this->adminRoute()->register();
		}
	}

	private function publishConfig()
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([
				$this->packagePath("config") => config_path(),
			], "config");
		}
	}

	private function registerCommand()
	{
		if (app()->runningInConsole()) {
			$this->commands(NewAdminUser::class);
		}
	}

	private function bootTools()
	{
		ImageLinkFormat::boot();
	}

	private function bootView()
	{
		$this->loadViewsFrom(__DIR__ . '/../../resources/views', 'kiwi');
	}

	private function bootWeb()
	{
		// 回源到server的协议是http, 所以通过request得到的也是http, 这里线上需要强制改成https
		URL::forceScheme(config("kiwi.scheme.web"));
	}

	private function bootAdmin()
	{
		$this->setAdminDefaultConfig();

		$this->bootAdminMenu();
		$this->bootAdminAuth();
		$this->bootAdminUpload();
		$this->bootAdminExtension();

		$this->loadAdminRoutes();

		app(ElementImporter::class)->boot();
	}

	private function bootApi()
	{
		$this->loadApiRoute();
	}

	private function setAdminDefaultConfig()
	{
		$file = useDcat() ? "dcat.php" : "encore.php";
		$this->mergeConfigFrom($this->packagePath("resources/config/$file"), "admin");
	}

	private function bootAdminMenu()
	{
		app(AdminMenu::class)->boot();
	}

	private function bootAdminAuth()
	{
		if (app()->runningInConsole()) {
			return;
		}
		app(AdminAuth::class)->boot();
	}

	private function bootAdminUpload()
	{
		config(["admin.upload" => config("kiwi.upload")]);
	}

	private function bootAdminExtension()
	{
		config(["admin.extensions" => config("kiwi.admin.extensions")]);
	}

	private function loadAdminRoutes()
	{
		$this->adminRoute()->boot();
		app(Route::class)->boot();
	}

	private function loadApiRoute()
	{
		$router = app('router');
		/** @var Router $router */
		if (!$router->hasMiddlewareGroup("api")) {
			// register default middleware group
			$router->middlewareGroup("api", []);
		}

		loadRouteFile("api", "api", "App\\Http\\Controllers\\Api", "api.php");
	}

	private function adminRoute(): AdminRoute
	{
		return app(AdminRoute::class);
	}

	private function packagePath($path): string
	{
		return __DIR__ . "/../../$path";
	}
}
