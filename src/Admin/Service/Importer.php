<?php


namespace Kiwi\Core\Admin\Service;


interface Importer
{
	public function handle(array $data, string $type): void;
}