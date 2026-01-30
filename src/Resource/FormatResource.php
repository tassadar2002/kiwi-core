<?php

namespace Kiwi\Core\Resource;


trait FormatResource
{
	protected int|string $format = 0;

	public function withFormat(int|string $format): self
	{
		$this->format = $format;
		return $this;
	}
}