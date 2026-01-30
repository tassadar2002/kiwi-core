<?php


namespace Kiwi\Core\Admin\Service;

/**
 * 多站点
 * Class AdminSite
 * @package Kiwi\Core\Admin\Service
 */
class AdminSite
{
	/**
	 * 是否存在multi site
	 * @return bool
	 */
	public function isEnable(): bool
	{
		return !empty(config("kiwi.sites.name"));
	}

	public function isMainSite(): bool
	{
		return empty($this->siteName());
	}

	public function siteName(): string
	{
		return config("kiwi.site");
	}

	/**
	 * 渲染multi site菜单
	 * @return string|null
	 */
	public function renderMenu(): ?string
	{
		if (!$this->isEnable()) {
			return "";
		}

		if (useEncore()) {
			$li = [];
			foreach ($this->siteNames() as $name => $alias) {
				$li[] = $this->renderItem($name, $alias);
			}
			$str = implode("", $li);
			$currentAlias = $this->currentAlias();

			return <<<HTML
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">$currentAlias<span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">$str</ul>
</li>
HTML;
		}

		if (useDcat()) {
			return \Dcat\Admin\Widgets\Dropdown::make($this->siteNames())
				->button($this->currentAlias())
				->map(function ($label, $key) {
					return "<a href='/?site=$key'>{$label}</a>";
				});
		}
		return "";
	}

	/**
	 * 配置当前site到系统
	 */
	public function configCurrent(): void
	{
		$site = $this->current();
		setcookie("site", $site, time() + 60 * 60 * 24 * 30, "/");
		config(["kiwi.site" => $site]);
	}

	/**
	 * 渲染一个site的菜单项
	 * @param string $name
	 * @param string $alias
	 * @return string
	 */
	private function renderItem(string $name, string $alias): string
	{
		return "<li><a href='/?site=$name'><span>$alias</span></a></li>";
	}

	/**
	 * 当前site名称
	 * @return string
	 */
	protected function current(): string
	{
		if (request()->path() === "/" || request()->path() === "admin") {
			// 入口路由, 切换site
			$site = request()->query("site");
		} else {
			$site = request()->cookie("site", "");
		}
		return $site ?? "";
	}

	/**
	 * 当前site的别名
	 * @return string
	 */
	protected function currentAlias(): string
	{
		$current = $this->current();
		foreach ($this->siteNames() as $name => $alias) {
			if ($name === $current) {
				return $alias;
			}
		}
		return "";
	}

	/**
	 * 所有站点名称
	 * @return array
	 */
	private function siteNames(): array
	{
		return array_merge(["" => "main"], config("kiwi.sites.name", []));
	}
}