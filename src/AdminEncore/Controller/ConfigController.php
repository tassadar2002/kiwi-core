<?php

namespace Kiwi\Core\AdminEncore\Controller;

use Encore\Admin\Controllers\AdminController;
use Kiwi\Core\AdminEncore\Service\Compatible;

class ConfigController extends AdminController
{
	use Compatible;
	use \Kiwi\Core\Admin\Controller\ConfigController;
}
