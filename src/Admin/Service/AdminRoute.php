<?php


namespace Kiwi\Core\Admin\Service;


use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use Kiwi\Core\Admin\Middleware\Role;

class AdminRoute
{
	public function register(): void
	{
		/**
		 * 不使用encore,dcat的默认中间件, 如果admin.auth为true, 则使用encore默认的中间件
		 * 默认的还进行了的登录及权限的校验, 虽然通过config不进行校验, 不过还是去掉吧
		 * 会取代encore注册的admin的group
		 */
		$group = [
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
		];
		if (useEncore()) {
			$group = array_merge($group, [
				\Encore\Admin\Middleware\Pjax::class,
				\Encore\Admin\Middleware\Bootstrap::class,
			]);
		}
		if (useDcat()) {
			$group = array_merge($group, [
				\Dcat\Admin\Http\Middleware\Pjax::class,
				\Dcat\Admin\Http\Middleware\Bootstrap::class,
				\Dcat\Admin\Http\Middleware\WebUploader::class,

				// 不使用多应用
//				\Dcat\Admin\Http\Middleware\Application::class,
			]);
		}
		app('router')->middlewareGroup("admin", $group);
		app('router')->aliasMiddleware("role", Role::class);
	}

	public function boot(): void
	{
		if (useEncore()) {
			$this->encoreRoute();
		}
		if (useDcat()) {
			$this->dcatRoute();
		}
		$this->baseRoute();
	}

	/**
	 * 加载admin路由，供派生项目使用
	 * @param bool $auth 加载的路由是否需要权限
	 * @param string|null $role 加载的路由所需要的角色
	 * @param string $namespace 命名空间
	 * @return RouteRegistrar
	 */
	public function baseRegistrar(bool $auth, ?string $role, string $namespace = "\App\Admin\Controllers"): RouteRegistrar
	{
		$result = Route::namespace($namespace)
			->domain(config('kiwi.domain.admin', "admin.localhost"));

		if (!empty($role)) {
			$middleware = $this->roleMiddleware($role);
		} else if ($auth) {
			$middleware = $this->authMiddleware();
		} else {
			$middleware = $this->defaultMiddleware();
		}

		return $result->middleware($middleware);
	}

	/**
	 * 不需要登录的中间件
	 * @return array
	 */
	private function defaultMiddleware(): array
	{
		return config('kiwi.admin.route.middleware', ['admin']);
	}

	/**
	 * 登录不需要角色的中间件
	 * @return array
	 */
	private function authMiddleware(): array
	{
		return array_merge(
			[AuthenticateWithBasicAuth::class,],
			$this->defaultMiddleware());
	}

	/**
	 * 需要角色的中间件
	 * @param string $role
	 * @return array
	 */
	private function roleMiddleware(string $role): array
	{
		return array_merge(
			[AuthenticateWithBasicAuth::class, "role:" . $role,],
			$this->defaultMiddleware());
	}

	/**
	 * 替代 Admin::routes(), 不启用 /auth/* 的路由
	 */
	private function encoreRoute(): void
	{
		\Illuminate\Support\Facades\Route::group([
			'middleware' => config('kiwi.admin.route.middleware', 'admin'),
			'namespace' => '\Encore\Admin\Controllers',
			'domain' => config('kiwi.domain.admin', "admin.localhost"),
		], function (Router $router) {
			$router->post('_handle_form_', 'HandleController@handleForm')->name('admin.handle-form');
			$router->post('_handle_action_', 'HandleController@handleAction')->name('admin.handle-action');
			$router->get('_handle_selectable_', 'HandleController@handleSelectable')->name('admin.handle-selectable');
			$router->get('_handle_renderable_', 'HandleController@handleRenderable')->name('admin.handle-renderable');
		});
	}

	private function dcatRoute(): void
	{
	}

	private function baseRoute(): void
	{
		\Illuminate\Support\Facades\Route::group([
			'middleware' => config('kiwi.admin.route.middleware', 'admin'),
			'namespace' => '\Kiwi\Core\Admin\Controller',
			'domain' => config('kiwi.domain.admin', "admin.localhost"),
		], function (Router $router) {
			$router->get("/auth/logout", "AuthController@logout");
		});
	}
}