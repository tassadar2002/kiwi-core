<?php

use Carbon\Carbon;
use Illuminate\Routing\Router;
use Kiwi\Core\Service\ImageLinkFormat;

if (!function_exists("site")) {
	function site(): string
	{
		return config('kiwi.site', "");
	}
}

if (!function_exists("image")) {
	function image($path): string
	{
		return app(ImageLinkFormat::class)->absolute($path);
	}
}

if (!function_exists("assetUrl")) {
	function assetUrl(string $path): string
	{
		return strtolower(config("kiwi.scheme.web")) === "https" ?
			secure_asset($path) :
			asset($path);
	}
}

if (!function_exists("textDate")) {
	function textDate(Carbon $date, string $format = 'm-d'): string
	{
		if ($date->isToday()) {
			return '今天';
		} elseif ($date->isYesterday()) {
			return '昨天';
		} else {
			return $date->format($format);
		}
	}
}

if (!function_exists("textWeek")) {
	function textWeek(Carbon $date, $format = 'm-d'): string
	{
		$dateStr = $date->format($format);
		$week = week($date);
		return "$dateStr 周{$week}";
	}
}

if (!function_exists("week")) {
	function week(Carbon $date): int
	{
		$map = [
			"日", "一", "二", "三", "四", "五", "六",
		];
		if ($date->dayOfWeek < 0 || $date->dayOfWeek > 6) {
			return $date->dayOfWeek;
		}
		return $map[$date->dayOfWeek];
	}
}

if (!function_exists("price")) {
	function price(int $value, bool $fillUp = true): string
	{
		if ($fillUp) {
			return number_format(((double)$value) / 100, 2);
		} else {
			return round(((double)$value) / 100, 2);
		}
	}
}

if (!function_exists("loadRouteFile")) {
	function loadRouteFile(string $domainType, string $middleware, string $namespace, string $fileName): void
	{
		if ($domainType === "pc" || $domainType === "mobile") {
			$filePath = rtrim("routes/" . config('kiwi.site'), '/');
			$filePath = base_path("$filePath/$fileName");
		} else {
			$filePath = base_path("routes/$fileName");
		}

		$domain = config("kiwi.domain.$domainType");

		if (file_exists($filePath) && !empty($domain)) {
			$router = app('router');
			/** @var Router $router */

			$registrar = $router
				->domain($domain)
				->namespace($namespace);

			if ($router->hasMiddlewareGroup($middleware)) {
				$registrar = $registrar->middleware($middleware);
			}

			$registrar->group($filePath);
		}
	}
}

if (!function_exists("loadRouteArray")) {
	function loadRouteArray(string $domainType, string $middleware, string $namespace, Closure $group): void
	{
		$domain = config("kiwi.domain.$domainType");

		if (!empty($domain)) {
			$router = app('router');
			/** @var Router $router */

			// 不能使用以下, route:cache之后会不生效
//			if (!$router->hasMiddlewareGroup($middleware)) {
//				$router->middlewareGroup($middleware, []);
//			}

			$registrar = $router
				->domain($domain)
				->namespace($namespace);

			if ($router->hasMiddlewareGroup($middleware)) {
				$registrar = $registrar->middleware($middleware);
			}

			$registrar->group($group);
		}
	}
}

if (!function_exists("useEncore")) {
	function useEncore(): bool
	{
		return config("kiwi.admin.framework") === "encore";
	}
}

if (!function_exists("useDcat")) {
	function useDcat(): bool
	{
		return config("kiwi.admin.framework") === "dcat";
	}
}