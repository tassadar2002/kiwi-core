<?php


namespace Kiwi\Core\Service;


use Illuminate\Support\Str;

class ImageLinkFormat
{
	private static ?string $scheme;
	private static ?string $domain;

	public static function boot(): void
	{
		if (empty(self::$scheme)) {
			self::$scheme = config("kiwi.scheme.image");
		}
		if (empty(self::$domain)) {
			self::$domain = config("kiwi.domain.image");
		}
	}

	/**
	 * 是否为绝对链接
	 * @param string|null $value
	 * @return bool
	 */
	public function isAbsolute(?string $value): bool
	{
		if (empty($value)) {
			return false;
		}
		return Str::startsWith($value, "http://") ||
			Str::startsWith($value, "https://") ||
			Str::startsWith($value, "//");
	}

	/**
	 * 相对便绝对链接
	 * @param string|null $value
	 * @return string
	 */
	public function absolute(?string $value): string
	{
		if (empty($value)) {
			return "";
		}

		if ($this->isAbsolute($value)) {
			return $value;
		}

		// css class
		if (Str::startsWith($value, ":")) {
			// 雪碧图
			return substr($value, 1);
		}

		// placeholder
		if ($value === "#") {
			return $value;
		}

		if (!Str::startsWith($value, "/")) {
			// article/12/ac/123456789.jpg
			$value = "/" . $value;
		}

		// http://image.xxx.com/article/12/ac/123456789.jpg
		return self::$scheme . "://" . self::$domain . $value;
	}

	/**
	 * 绝对变相对链接
	 * @param string|null $value
	 * @return string
	 */
	public function relative(?string $value): string
	{
		if (empty($value)) {
			return "";
		}
		if ($value === "#") {
			return $value;
		}

		//    http://image.xxx.com
		if (Str::startsWith($value, self::$scheme . "://" . self::$domain)) {
			//   http://image.xxx.com/article/12/ac/123456789.jpg
			return str_replace(self::$scheme . "://" . self::$domain, "", $value);
		}

		//    //image.xxx.com
		if (Str::startsWith($value, "//" . self::$domain)) {
			//   //image.xxx.com/article/12/ac/123456789.jpg
			return str_replace("//" . self::$domain, "", $value);
		}

		// other domain absolute link
		if (Str::startsWith("http://", $value) || Str::startsWith("https://", $value) || Str::startsWith("//", $value)) {
			// https://abc.com/123456789.jpg
			return $value;
		}

		// already relative
		if (Str::startsWith($value, "/")) {
			//    /article/12/ac/123456789.jpg
			return $value;
		}
		return "$value";
	}
}
