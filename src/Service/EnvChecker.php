<?php


namespace Kiwi\Core\Service;


class EnvChecker
{
	public static function isWeb(): bool
	{
		return self::isLocal() || self::isRole("web");
	}

	public static function isAdmin(): bool
	{
		return self::isLocal() || self::isRole("admin");
	}

	public static function isApi(): bool
	{
		return self::isLocal() || self::isRole("api");
	}

	public static function isProduction(): bool
	{
		return self::isProfile("production");
	}

	public static function isLocal(): bool
	{
		return self::isProfile("local");
	}

	public static function isProfile(string $name): bool
	{
		return app()->environment([$name]);
	}

	public static function isRole(string $name): bool
	{
		return env("ROLE") === $name || config("kiwi.role") === $name;
	}
}