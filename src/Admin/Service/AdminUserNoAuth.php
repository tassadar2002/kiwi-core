<?php

namespace Kiwi\Core\Admin\Service;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * 模拟后台用户, 通过Auth::guard("admin")->setUser注入用户对象
 * Class AdminUser
 * @package App\Admin\Extend
 */
class AdminUserNoAuth extends Model implements Authenticatable
{
	public string $avatar = "";

	public function __construct()
	{
		parent::__construct();
		// for encore
		$this->avatar = config('kiwi.admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';
	}

	public function getAuthIdentifierName()
	{
		return "admin";
	}

	public function getAuthIdentifier()
	{
		return 0;
	}

	public function getAuthPassword()
	{
		return "admin";
	}

	public function getRememberToken()
	{
		return "admin";
	}

	public function setRememberToken($value)
	{

	}

	public function getRememberTokenName()
	{
		return "admin";
	}

	// for view partial.menu
	public function can($ability, $arguments = []): bool
	{
		return true;
	}

	// for view partial.menu
	public function visible(array $roles = []): bool
	{
		return true;
	}

	public function getAvatar(): string
	{
		// for dcat
		return config('kiwi.admin.default_avatar') ?: '/vendor/dcat-admin/images/logo.png';
	}
}
