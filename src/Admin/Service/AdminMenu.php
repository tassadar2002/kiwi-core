<?php

namespace Kiwi\Core\Admin\Service;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * 菜单, 不从数据库进行查找, 直接读取配置文件
 *
 * Class AdminMenu
 * @package App\Admin\Extend
 */
class AdminMenu
{
	private AdminSite $adminSite;

	public function __construct()
	{
		$this->adminSite = app(AdminSite::class);
	}

	public function boot(): void
	{
		config(["admin.database.menu_model" => static::class]);
	}

	public function allNodes(): Collection
	{
		#todo 这部分代码需要完善
		$menuTmp = collect();
		$idStart = 10000;
		$subIdStart = 20000;

		if (AdminAuth::isEnableRole()) {
			$user = Auth::guard("admin")->user();
			if (empty($user)) {
				return $menuTmp;
			}
			/** @var AdminUser $user */

			if (!$this->isEnableSite()) {
				$menu = $this->singleMenu($user->role);
			} else {
				if ($this->isMainSite()) {
					$menu = $this->mainMenu($user->role);
				} else {
					$menu = $this->siteMenu($user->role);
				}
			}
		} else {
			if (!$this->isEnableSite()) {
				$menu = $this->singleMenu();
			} else {
				if ($this->isMainSite()) {
					$menu = $this->mainMenu();
				} else {
					$menu = $this->siteMenu();
				}
			}
		}

		foreach ($menu as $i => $element) {
			$id = $idStart + $i;
			$menuTmp->push([
				'id' => $id,
				'parent_id' => 0,
				'order' => $element['order'] ?? 0,
				'uri' => $element['uri'] ?? '',
				'icon' => $element['icon'] ?? '',
				'title' => __($element['title'] ?? ''),
			]);
			// 子菜单
			if (isset($element['children'])) {
				foreach ($element['children'] as $ii => $ele) {
					$menuTmp->push([
						'id' => $subIdStart + $ii,
						'parent_id' => $id,
						'order' => $ele['order'] ?? 0,
						'uri' => $ele['uri'] ?? '',
						'icon' => $ele['icon'] ?? '',
						'title' => __($ele['title'] ?? ''),
					]);
				}
			}
		}

		return $menuTmp;
	}

	public function toTree(): array
	{
		if (AdminAuth::isEnableRole()) {
			$user = Auth::guard("admin")->user();
			if (empty($user)) {
				return [];
			}
			/** @var AdminUser $user */

			if (!$this->isEnableSite()) {
				return $this->singleMenu($user->role);
			}
			if ($this->isMainSite()) {
				return $this->mainMenu($user->role);
			} else {
				return $this->siteMenu($user->role);
			}
		} else {
			if (!$this->isEnableSite()) {
				return $this->singleMenu();
			}
			if ($this->isMainSite()) {
				return $this->mainMenu();
			} else {
				return $this->siteMenu();
			}
		}
	}

	protected function isEnableSite(): bool
	{
		return $this->adminSite->isEnable();
	}

	protected function isMainSite(): bool
	{
		return $this->adminSite->isMainSite();
	}

	protected function singleMenu(?string $role = null): array
	{
		if (empty($role)) {
			return config("menu");
		} else {
			return config("menu.$role");
		}
	}

	protected function mainMenu(?string $role = null): array
	{
		if (empty($role)) {
			return config("menu.main");
		} else {
			return config("menu.main.$role");
		}
	}

	protected function siteMenu(?string $role = null): array
	{
		$name = $this->adminSite->siteName();
		if (empty($role)) {
			return config("menu.$name") ?? config("menu.site");
		} else {
			return config("menu.$name.$role") ?? config("menu.site.$role");
		}
	}
}
