<?php

return [

	/*
	|--------------------------------------------------------------------------
	| dcat-admin name
	|--------------------------------------------------------------------------
	|
	| This value is the name of dcat-admin, This setting is displayed on the
	| login page.
	|
	*/
	'name' => env("APP_NAME"),

	/*
	|--------------------------------------------------------------------------
	| dcat-admin logo
	|--------------------------------------------------------------------------
	|
	| The logo of all admin pages. You can also set it as an image by using a
	| `img` tag, eg '<img src="http://logo-url" alt="Admin logo">'.
	|
	*/
	'logo' => '<b>' . ucfirst(env("APP_NAME")) . '</b>',

	/*
	|--------------------------------------------------------------------------
	| dcat-admin mini logo
	|--------------------------------------------------------------------------
	|
	| The logo of all admin pages when the sidebar menu is collapsed. You can
	| also set it as an image by using a `img` tag, eg
	| '<img src="http://logo-url" alt="Admin logo">'.
	|
	*/
	'logo-mini' => '<b>' . ucfirst(env("APP_NAME"))[0] . '</b>',

	/*
	|--------------------------------------------------------------------------
	| dcat-admin favicon
	|--------------------------------------------------------------------------
	|
	*/
	'favicon' => null,

	/*
	 |--------------------------------------------------------------------------
	 | User default avatar
	 |--------------------------------------------------------------------------
	 |
	 | Set a default avatar for newly created users.
	 |
	 */
	'default_avatar' => '/vendor/dcat-admin/images/default-avatar.jpg',

	/*
	|--------------------------------------------------------------------------
	| dcat-admin html title
	|--------------------------------------------------------------------------
	|
	| Html title for all pages.
	|
	*/
	'title' => ucfirst(env("APP_NAME")) . " Admin",

	/*
	|--------------------------------------------------------------------------
	| Assets hostname
	|--------------------------------------------------------------------------
	|
   */
	'assets_server' => env('ADMIN_ASSETS_SERVER'),

	/*
	|--------------------------------------------------------------------------
	| Access via `https`
	|--------------------------------------------------------------------------
	|
	| If your page is going to be accessed via https, set it to `true`.
	|
	*/
	'https' => env('ADMIN_HTTPS', false),

	/*
	|--------------------------------------------------------------------------
	| The global Grid setting
	|--------------------------------------------------------------------------
	*/
	'grid' => [

		// The global Grid action display class.
		'grid_action_class' => Dcat\Admin\Grid\Displayers\DropdownActions::class,

		// The global Grid batch action display class.
		'batch_action_class' => Dcat\Admin\Grid\Tools\BatchActions::class,

		// The global Grid pagination display class.
		'paginator_class' => Dcat\Admin\Grid\Tools\Paginator::class,

		'actions' => [
			'view' => Dcat\Admin\Grid\Actions\Show::class,
			'edit' => Dcat\Admin\Grid\Actions\Edit::class,
			'quick_edit' => Dcat\Admin\Grid\Actions\QuickEdit::class,
			'delete' => Dcat\Admin\Grid\Actions\Delete::class,
			'batch_delete' => Dcat\Admin\Grid\Tools\BatchDelete::class,
		],

		// The global Grid column selector setting.
		'column_selector' => [
			'store' => Dcat\Admin\Grid\ColumnSelector\SessionStore::class,
			'store_params' => [
				'driver' => 'file',
			],
		],
	],

	/*
	|--------------------------------------------------------------------------
	| dcat-admin helpers setting.
	|--------------------------------------------------------------------------
	*/
	'helpers' => [
		'enable' => false,
	],

	/*
	|--------------------------------------------------------------------------
	| Application layout
	|--------------------------------------------------------------------------
	|
	| This value is the layout of admin pages.
	*/
	'layout' => [
		// default, blue, blue-light, green
		'color' => 'default',

		// sidebar-separate
		'body_class' => [],

		'horizontal_menu' => false,

		'sidebar_collapsed' => false,

		// light, primary, dark
		'sidebar_style' => 'light',

		'dark_mode_switch' => true,

		// bg-primary, bg-info, bg-warning, bg-success, bg-danger, bg-dark
		'navbar_color' => '',
	],

	/*
	|--------------------------------------------------------------------------
	| The exception handler class
	|--------------------------------------------------------------------------
	|
	*/
	'exception_handler' => Dcat\Admin\Exception\Handler::class,

	/*
	|--------------------------------------------------------------------------
	| Enable default breadcrumb
	|--------------------------------------------------------------------------
	|
	| Whether enable default breadcrumb for every page content.
	*/
	'enable_default_breadcrumb' => true,

	/*
	|--------------------------------------------------------------------------
	| Extension
	|--------------------------------------------------------------------------
	*/
	'extension' => [
		// When you use command `php artisan admin:ext-make` to generate extensions,
		// the extension files will be generated in this directory.
		'dir' => base_path('dcat-admin-extensions'),
	],
];