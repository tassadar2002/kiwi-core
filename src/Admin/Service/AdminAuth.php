<?php


namespace Kiwi\Core\Admin\Service;


use Illuminate\Support\Facades\Auth;

class AdminAuth
{
	public function boot(): void
	{
		if (self::isEnable()) {
			$this->authSetting();
		} else {
			$this->noAuthSetting();
		}
	}

	public static function isEnable(): bool
	{
		return config("kiwi.admin.auth.enable");
	}

	public static function isEnableRole(): bool
	{
		return self::isEnable() && config("kiwi.admin.role.enable");
	}

	public static function checkRole(array $roles): bool
	{
		$user = Auth::user();
		/** @var AdminUser $user */

		if (in_array($user->role, $roles, true)) {
			return true;
		}
		return false;
	}

	/**
	 * 除了 auth.providers.admin.model , 其他都使用默认值config文件中的值
	 * 简化起见, 这里写死, 就不读取config了
	 */
	private function authSetting(): void
	{
		config(["auth" => [
			"defaults" => [
				// basic auth use default guard
				"guard" => "admin",
			],
			"guards" => [
				"admin" => [
					"driver" => "session",
					"provider" => "admin",
				],
			],
			"providers" => [
				"admin" => [
					"driver" => "eloquent",
					"model" => AdminUser::class,
				],
			],
		]]);
	}

	/**
	 * 页面需要user对象
	 */
	private function noAuthSetting(): void
	{
		$this->authSetting();
		Auth::guard("admin")->setUser(new AdminUserNoAuth());
	}
}
