<?php


namespace Kiwi\Core\Admin\Service;


use Kiwi\Core\Model\Element;

class ElementImporter implements Importer
{
	public function boot()
	{
		config(["kiwi.admin.importer.element" => static::class]);
	}

	public function handle(array $data, string $type): void
	{
		foreach ($data as $row) {
			$element = new Element();
			$element->name = $row[0];
			$element->parent = $row[1];
			$element->title = $row[2];
			$element->subtitle = $row[3];
			$element->image = $row[4];
			$element->link = $row[5];
			$element->attribute = $row[6];
			$element->order = (int)$row[7];
			$element->save();
		}
	}

}