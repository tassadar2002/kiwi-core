<?php

namespace Kiwi\Core\Admin\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Routing\RouteRegistrar baseRegistrar(bool $auth, ?string $role, string $namespace = "\App\Admin\Controllers")
 */
class AdminRoute extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return \Kiwi\Core\Admin\Service\AdminRoute::class;
	}
}