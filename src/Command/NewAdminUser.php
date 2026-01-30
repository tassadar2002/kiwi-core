<?php

namespace Kiwi\Core\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Kiwi\Core\Admin\Service\AdminUser;

class NewAdminUser extends Command
{
	protected $signature = "kiwi:new-user {name} {password} {role}";

	public function handle()
	{
		$name = $this->argument("name");
		$password = $this->argument("password");
		$role = $this->argument("role");

		if (AdminUser::query()->where("email", $name)->count() != 0) {
			$this->error("already exists same name user");
			return;
		}

		$user = new AdminUser();
		$user->email = $name;
		$user->password = Hash::make($password);
		$user->role = $role;
		$user->save();
		$user->refresh();

		$this->info("create {$user->id} ok");
	}
}