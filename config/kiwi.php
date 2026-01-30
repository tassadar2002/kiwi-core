<?php

return [
	"role" => env("ROLE", ""),

	// 当前站点名称, 多站点时有意义
	"site" => env('SITE', ''),

	// 多站点设置
	"sites" => [
		// 使用多表(table)还是多数据库(database)保存多站点信息
		"store" => "table",
		// 所有站点的 key => title
		"name" => [
			"coupons2" => "ava",
			"coupons3" => "cf",
		],
		// 需要多站点的model
		"model" => [
			\Kiwi\Core\Model\Config::class,
			\Kiwi\Core\Model\Element::class,
		]
	],

	// 域名
	"domain" => [
		"admin" => env('DOMAIN_ADMIN'),
		"api" => env("DOMAIN_API"),
		"image" => env("DOMAIN_IMAGE"),
	],

	// 协议
	"scheme" => [
		"web" => env("SCHEME_WEB", "http"),
		"admin" => env("SCHEME_ADMIN", "http"),
		"api" => env("SCHEME_API", "http"),
		"image" => env("SCHEME_IMAGE", "http"),
	],

	// admin配置
	"admin" => [
		"framework" => "encore", // dcat
		// 是否需要登录
		"auth" => ["enable" => false,],
		// 是否需要角色
		"role" => ["enable" => false,],
		// 导入操作类
		"importer" => [
			"element" => \Kiwi\Core\Admin\Service\ElementImporter::class,
		],
		"extensions" => [

		],
	],

	// 上传文件的配置, FileService使用
	"upload" => [
		"disk" => "oss",
	],

	// 全局缓存时间, LocalCache 使用
	"global_cache_time" => env("GLOBAL_CACHE_TIME", 1800),
];