<?php

namespace Kiwi\Core\Repository;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use stdClass;

class BaseRepository
{
	/**
	 * @return null|Builder
	 */
	protected function query(): ?Builder
	{
		return null;
	}

	/**
	 * @param int $id
	 * @return Model|stdClass|null
	 */
	public function findById(int $id)
	{
		return $this->query()->find($id);
	}

	/**
	 * @param array $ids
	 * @return Collection
	 */
	public function findByIds(array $ids): Collection
	{
		return $this->query()->find($ids);
	}

	/**
	 * @param ?Closure $condition
	 * @param Closure|null $pager
	 * @param Closure|null $sorter
	 * @param Closure|null $selector
	 * @return Collection
	 */
	public function findByCondition(
		?Closure $condition,    // WHERE
		?Closure $pager = null,    // SKIP LIMIT
		?Closure $sorter = null,    // ORDER BY
		?Closure $selector = null    // SELECT
	): Collection
	{
		$query = $this->query();
		if (!empty($condition)) {
			$query = $condition->call($this, $query);
		}
		if (!empty($sorter)) {
			$query = $sorter->call($this, $query);
		}
		if (!empty($pager)) {
			$query = $pager->call($this, $query);
		}
		if (!empty($selector)) {
			$query = $selector->call($this, $query);
		}
		return $query->get();
	}

	/**
	 * @param ?Closure $condition
	 * @return int
	 */
	public function countByCondition(?Closure $condition): int
	{
		$query = $this->query();
		if (!empty($condition)) {
			$query = $condition->call($this, $query);
		}
		return $query->count();
	}

	/**
	 * @param ?Closure $condition
	 * @return Model|stdClass|null
	 */
	public function firstByCondition(?Closure $condition)
	{
		$query = $this->query();
		if (!empty($condition)) {
			$query = $condition->call($this, $query);
		}
		return $query->first();
	}
}