<?php


namespace Kiwi\Core\Repository;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Kiwi\Core\Model\Element;

class ElementRepository extends BaseRepository
{
	protected function query(): ?Builder
	{
		return Element::query();
	}

	/**
	 * @param string $name
	 * @return Element|null
	 */
	public function findByName(string $name): ?Element
	{
		return $this->query()->where("name", $name)->first();
	}

	/**
	 * @param string $parent
	 * @return Collection
	 */
	public function findByParent(string $parent): Collection
	{
		return $this->query()
			->where("parent", $parent)
			->orderBy("order")
			->get();
	}
}