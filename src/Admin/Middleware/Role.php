<?php

namespace Kiwi\Core\Admin\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Kiwi\Core\Admin\Service\AdminAuth;

class Role
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 * @param array|null ...$roles
	 * @return mixed
	 *
	 * @throws AuthorizationException
	 */
	public function handle(mixed $request, Closure $next, ...$roles): mixed
	{
		if (AdminAuth::checkRole($roles)) {
			return $next($request);
		}
		throw new AuthorizationException();
	}
}
