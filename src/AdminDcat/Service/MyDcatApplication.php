<?php

namespace Kiwi\Core\AdminDcat\Service;


use Dcat\Admin\Application;
use Illuminate\Support\Facades\Route;

class MyDcatApplication extends Application
{
	protected function loadRoutesFrom($path, ?string $app)
	{
		Route::group(array_filter([
//			'as' => $this->getRoutePrefix($app),    // 所有用到 dcat-api 的地方会用到，如各种 Action
		]), $path);
	}

	// 不使用 dcat.admin 开头，通过 Router::has 来实现路由的覆盖
	public function getRoutePrefix(?string $app = null)
	{
		return "";
	}
}