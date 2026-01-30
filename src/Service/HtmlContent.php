<?php

namespace Kiwi\Core\Service;


use Closure;
use phpQuery;

class HtmlContent
{
	protected ImageLinkFormat $link;
	protected string $firstImageUrl = "";

	public function __construct()
	{
		$this->link = app(ImageLinkFormat::class);
	}

	public function getFirstImageUrl(): ?string
	{
		return $this->firstImageUrl;
	}

	/**
	 * 图片链接修改为相对链接
	 * @param string|null $content
	 * @return string
	 */
	public function encode(?string $content): string
	{
		return $this->convertImage($content,
			function ($src) {
				return $this->link->relative($src);
			}
		);
	}

	/**
	 * 图片链接修改为绝对链接，并调整大小
	 * @param string|null $content
	 * @return string
	 */
	public function decode(?string $content): string
	{
		return $this->convertImage(
			$content,
			function ($src) {
				return $this->link->absolute($src);
			});
	}

	/**
	 * @param string|null $content
	 * @param Closure|null $imgSrcConverter 修改属性值
	 * @param Closure|null $elementConverter 修改属性元素
	 * @return string
	 */
	public function convertImage(?string $content,
								 Closure $imgSrcConverter = null,
								 Closure $elementConverter = null): string
	{
		if (empty($content)) {
			return "";
		}

		$doc = phpQuery::newDocumentHTML($content);
		foreach ($doc->find('img') as $image) {

			// image src
			$src = $image->getAttribute("src");
			if (!empty($imgSrcConverter)) {
				$src = $imgSrcConverter($src);
			}
			$image->setAttribute('src', $src);

			// set first image
			if (empty($this->firstImageUrl)) {
				$this->firstImageUrl = $src;
			}

			// element
			if (!empty($elementConverter)) {
				$elementConverter($image);
			}
		}
		return (string)$doc;
	}
}