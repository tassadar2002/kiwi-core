<?php

namespace Kiwi\Core\Admin\Service;


use Illuminate\Notifications\Notifiable;

/**
 * Class Admin
 * @package Kiwi\Core\Model
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @property string role
 */
class AdminUser extends \Illuminate\Foundation\Auth\User
{
	use Notifiable, DefaultDatetimeFormat;

	public $timestamps = true;
	protected $table = "admin";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'email', 'password', 'role',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function getAvatarAttribute()
	{
		// for encore
		return config('kiwi.admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';
	}

	public function getNameAttribute()
	{
		return $this->email;
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