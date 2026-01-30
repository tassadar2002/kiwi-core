<?php

namespace Kiwi\Core\Model;


trait Site
{
	public function setSiteInfo(): void
	{
		$site = config("kiwi.site");
        $site = str_replace('-', '_', $site);

		// 主站点
		if (empty($site)) {
			return;
		}

		if (!in_array(self::class, config("kiwi.sites.model", []))) {
			return;
		}

		$store = config("kiwi.sites.store", "table");
		if ($store === "table") {
			$this->table = "{$this->table}_{$site}";
		}
		if ($store === "database") {
			$this->connection = $site;
		}
	}
}
