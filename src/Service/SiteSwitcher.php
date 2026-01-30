<?php


namespace Kiwi\Core\Service;


class SiteSwitcher
{
	private ?string $origin = null;

	public function changeMain(): void
	{
		$this->change("");
	}

	public function change(string $site): void
	{
		$this->origin = config("kiwi.site");
		config(["kiwi.site" => $site]);
	}

	public function resume(): void
	{
		config(["kiwi.site" => $this->origin]);
	}
}