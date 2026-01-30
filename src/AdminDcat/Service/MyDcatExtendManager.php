<?php

namespace Kiwi\Core\AdminDcat\Service;

use Dcat\Admin\Extend\Manager;

class MyDcatExtendManager extends Manager
{
	public function enabled(?string $name): bool
	{
		return true;
	}
}