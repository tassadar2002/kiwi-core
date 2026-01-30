<?php

namespace Kiwi\Core\Admin\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void config(string $role)
 * @method static void editor(string $role)
 * @method static void import(string $role)
 */
class Route extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return \Kiwi\Core\Admin\Service\Route::class;
	}
}