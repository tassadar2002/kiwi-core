<?php


namespace Kiwi\Core\Admin\Service;


class Menu
{
	public static function main(): array
	{
		return [
			"title" => "Config",
			"icon" => "fa-cogs",
			"children" => [
				[
					"title" => "Element",
					"icon" => "fa-object-group",
					"uri" => "/elements",
				],
				[
					"title" => "Config",
					"icon" => "fa-cogs",
					"uri" => "/configs",
				],
				[
					"title" => "FileUpload",
					"icon" => "fa-file",
					"uri" => "/file/upload/form",
				],
			],
		];
	}

	public static function auth(): array
	{
		return [
			"title" => "AdminUser",
			"icon" => "fa-users",
			"uri" => "/admin-users",
		];
	}
}