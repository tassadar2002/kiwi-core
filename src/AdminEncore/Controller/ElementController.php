<?php

namespace Kiwi\Core\AdminEncore\Controller;

use Encore\Admin\Controllers\AdminController;
use Kiwi\Core\AdminEncore\Service\Compatible;

class ElementController extends AdminController
{
	use Compatible;
	use \Kiwi\Core\Admin\Controller\ElementController;
}
