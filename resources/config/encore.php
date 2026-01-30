<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laravel-admin name
	|--------------------------------------------------------------------------
	|
	| This value is the name of laravel-admin, This setting is displayed on the
	| login page.
	|
	*/
	'name' => ucfirst(env("APP_NAME")),

	/*
	|--------------------------------------------------------------------------
	| Laravel-admin logo
	|--------------------------------------------------------------------------
	|
	| The logo of all admin pages. You can also set it as an image by using a
	| `img` tag, eg '<img src="http://logo-url" alt="Admin logo">'.
	|
	*/
	'logo' => '<b>' . ucfirst(env("APP_NAME")) . '</b>',

	/*
	|--------------------------------------------------------------------------
	| Laravel-admin mini logo
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
	| Laravel-admin bootstrap setting
	|--------------------------------------------------------------------------
	|
	| This value is the path of laravel-admin bootstrap file.
	|
	*/
	'bootstrap' => app_path('Admin/bootstrap.php'),

	/*
	|--------------------------------------------------------------------------
	| Laravel-admin html title
	|--------------------------------------------------------------------------
	|
	| Html title for all pages.
	|
	*/
	'title' => ucfirst(env("APP_NAME")) . " Admin",

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
	| User default avatar
	|--------------------------------------------------------------------------
	|
	| Set a default avatar for newly created users.
	|
	*/
	'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',

	/*
	|--------------------------------------------------------------------------
	| Admin map field provider
	|--------------------------------------------------------------------------
	|
	| Supported: "tencent", "google", "yandex".
	|
	*/
	'map_provider' => 'google',

	/*
	|--------------------------------------------------------------------------
	| Application Skin
	|--------------------------------------------------------------------------
	|
	| This value is the skin of admin pages.
	| @see https://adminlte.io/docs/2.4/layout
	|
	| Supported:
	|    "skin-blue", "skin-blue-light", "skin-yellow", "skin-yellow-light",
	|    "skin-green", "skin-green-light", "skin-purple", "skin-purple-light",
	|    "skin-red", "skin-red-light", "skin-black", "skin-black-light".
	|
	*/
	'skin' => env('ADMIN_SKIN', 'skin-blue-light'),

	/*
	|--------------------------------------------------------------------------
	| Application layout
	|--------------------------------------------------------------------------
	|
	| This value is the layout of admin pages.
	| @see https://adminlte.io/docs/2.4/layout
	|
	| Supported: "fixed", "layout-boxed", "layout-top-nav", "sidebar-collapse",
	| "sidebar-mini".
	|
	*/
	'layout' => ['sidebar-mini'],

	/*
	|--------------------------------------------------------------------------
	| Show version at footer
	|--------------------------------------------------------------------------
	|
	| Whether to display the version number of laravel-admin at the footer of
	| each page
	|
	*/
	'show_version' => false,

	/*
	|--------------------------------------------------------------------------
	| Show environment at footer
	|--------------------------------------------------------------------------
	|
	| Whether to display the environment at the footer of each page
	|
	*/
	'show_environment' => true,

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
	| Enable/Disable assets minify
	|--------------------------------------------------------------------------
	*/
	'minify_assets' => [

		// Assets will not be minified.
		'excepts' => [

		],

	],

	/*
	|--------------------------------------------------------------------------
	| Enable/Disable sidebar menu search
	|--------------------------------------------------------------------------
	*/
	'enable_menu_search' => false,

	/*
	|--------------------------------------------------------------------------
	| Exclude route from generate menu command
	|--------------------------------------------------------------------------
	*/
	'menu_exclude' => [
		'_handle_selectable_',
		'_handle_renderable_',
	],

	/*
	|--------------------------------------------------------------------------
	| Alert message that will displayed on top of the page.
	|--------------------------------------------------------------------------
	*/
	'top_alert' => '',

	/*
	|--------------------------------------------------------------------------
	| The global Grid action display class.
	|--------------------------------------------------------------------------
	*/
	'grid_action_class' => \Encore\Admin\Grid\Displayers\DropdownActions::class,

	/*
	|--------------------------------------------------------------------------
	| Extension Directory
	|--------------------------------------------------------------------------
	|
	| When you use command `php artisan admin:extend` to generate extensions,
	| the extension files will be generated in this directory.
	*/
	'extension_dir' => app_path('Admin/Extensions'),

	/*
	|--------------------------------------------------------------------------
	| Settings for extensions.
	|--------------------------------------------------------------------------
	|
	| You can find all available extensions here
	| https://github.com/laravel-admin-extensions.
	|
	*/
	'extensions' => [

	],
];
