<?php

namespace Kiwi\Core\AdminDcat\Controller;

use Dcat\Admin\Http\Controllers\AdminController;
use Kiwi\Core\AdminDcat\Service\Compatible;

class ConfigController extends AdminController
{
	use Compatible;
	use \Kiwi\Core\Admin\Controller\ConfigController;
}
