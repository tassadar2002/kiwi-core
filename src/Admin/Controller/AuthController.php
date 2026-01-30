<?php


namespace Kiwi\Core\Admin\Controller;


use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
	public function logout(): RedirectResponse
	{
		// 给出错误的用户名和密码
		return redirect(preg_replace("/:\/\//", "://log-me-out:fake-pwd@", url('/')));
	}
}
