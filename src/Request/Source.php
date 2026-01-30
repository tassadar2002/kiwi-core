<?php


namespace Kiwi\Core\Request;


trait Source
{
	public function source(): string
	{
		$source = request()->query("utm_source");
		if (empty($source)) {
			$str = request()->cookie("source");
			if (!empty($str)) {
				$obj = json_decode($str, true);
				if (!empty($obj)) {
					$source = array_key_exists("utm_source", $obj) ? $obj["utm_source"] : "";
				}
			}
		}
		return empty($source) ? "" : $source;
	}
}