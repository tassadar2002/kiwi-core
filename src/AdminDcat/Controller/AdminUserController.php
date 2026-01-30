<?php

namespace Kiwi\Core\AdminDcat\Controller;

use Dcat\Admin\Http\Controllers\AdminController;
use Kiwi\Core\AdminDcat\Service\Compatible;

class AdminUserController extends AdminController
{
	use Compatible;
	use \Kiwi\Core\Admin\Controller\AdminUserController;
}