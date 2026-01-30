<?php


namespace Kiwi\Core\Admin\Service;


class ImportService
{
	public function import(string $fileName, string $type): void
	{
		$importer = config("kiwi.admin.importer.$type");
		if (empty($importer)) {
			return;
		}
		$importer = app($importer);
		/** @var Importer $importer */

		$rows = array_filter(file($fileName), function ($line) {
			return !empty(trim($line));
		});
		$rows = array_map('str_getcsv', $rows);
		$importer->handle($rows, $type);
	}
}