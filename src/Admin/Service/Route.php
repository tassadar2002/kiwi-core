<?php

namespace Kiwi\Core\Admin\Service;

use Illuminate\Routing\Router;
use Kiwi\Core\Service\EnvChecker;

class Route
{
	public function boot(): void
	{
		// isEnableRole, 因为派生项目要对core的route设置role，所以这里不再加载除auth之外的route
		if (!AdminAuth::isEnableRole()) {
			$this->selfRoute(AdminAuth::isEnable());
		}

		// 只要需要登录，就需要auth的route(logout和admin user)
		if (AdminAuth::isEnable()) {
			$this->auth();
		}
	}

	/**
	 * 加载当前模块的路由
	 * @param bool $auth
	 * @return void
	 */
	private function selfRoute(bool $auth): void
	{
		$this->registrar()->baseRegistrar($auth, null, $this->namespace())
			->group(function (Router $router) {
				$this->innerRouter($router, "config");
				$this->innerRouter($router, "editor");
				$this->innerRouter($router, "import");
				if (EnvChecker::isLocal()) {
					$this->innerRouter($router, "test");
				}
			});
	}

	/**
	 * 供派生项目使用，指定role
	 * @param string $role
	 * @return void
	 */
	public function config(string $role): void
	{
		$this->registrar()->baseRegistrar(true, $role, $this->namespace())
			->group(function (Router $router) {
				$this->innerRouter($router, "config");
			});
	}

	/**
	 * 供派生项目使用，指定role
	 * @param string $role
	 * @return void
	 */
	public function editor(string $role): void
	{
		$this->registrar()->baseRegistrar(true, $role, $this->namespace())
			->group(function (Router $router) {
				$this->innerRouter($router, "editor");
			});
	}

	/**
	 * 供派生项目使用，指定role
	 * @param string $role
	 * @return void
	 */
	public function import(string $role): void
	{
		$this->registrar()->baseRegistrar(true, $role, $this->namespace())
			->group(function (Router $router) {
				$this->innerRouter($router, "import");
			});
	}

	public function auth(): void
	{
		$this->registrar()->baseRegistrar(false, null, "\\Kiwi\\Core\\Admin\\Controller")
			->group(function (Router $router) {
				$router->get("/auth/logout", "AuthController@logout");
			});
		$this->registrar()->baseRegistrar(true, "admin", $this->namespace())
			->group(function (Router $router) {
				$router->resource('admin-users', "AdminUserController");
			});
	}

	private function innerRouter(Router $router, string $name): void
	{
		if ($name === "config") {
			$router->resource('configs', "ConfigController");
			$router->resource('elements', "ElementController");
		}
		if ($name === "editor") {
			$router->get("/file/upload/form/", "FileController@uploadForm")->name("file.upload.form");
			$router->post("/file/upload/{type?}/{name?}", "FileController@upload_")->name("file.upload");
			$router->post("/ckeditor/upload", "FileController@ckeditor")->name("ckeditor.upload");
		}
		if ($name === "import") {
			$router->post("/import/{name}", "ImportController@import")->name("import");
		}
		if ($name === "test") {
			$router->get("/test", "TestController@index");
		}
	}

	private function namespace(): string
	{
		if (useEncore()) {
			return "\\Kiwi\\Core\\AdminEncore\\Controller";
		}
		if (useDcat()) {
			return "\\Kiwi\\Core\\AdminDcat\\Controller";
		}
		return "";
	}

	private function registrar(): AdminRoute
	{
		return app(AdminRoute::class);
	}
}