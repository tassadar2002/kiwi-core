<?php

namespace Kiwi\Core\Repository;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kiwi\Core\Service\LocalCache;
use stdClass;

trait LocalCacheRepository
{
	protected bool $useCache = true;

	/**
	 * 用于优化请求次数
	 * @var null|array
	 */
	private static ?array $models = null;

	/**
	 * @return Builder|null
	 */
	protected function query(): ?Builder
	{
		return null;
	}

	/**
	 * 缓存的key
	 * @return string
	 */
	abstract protected function cacheKey(): string;

	/**
	 * 创建缓存项的一个元素
	 * @param Model $model
	 * @return stdClass
	 */
	abstract protected function createItem(Model &$model): stdClass;

	/**
	 * 排序缓存项的元素
	 * @param Collection $models
	 * @return Collection
	 */
	protected function sort(Collection $models): Collection
	{
		return $models;
	}

	/**
	 * 删除缓存
	 */
	public function reset(): void
	{
		self::$models = null;
		$this->getLocalCache()->remove($this->cacheKey());
	}

	/**
	 * @return array
	 */
	public function all(): array
	{
		if (self::$models !== null) {
			return self::$models;
		}

		// 不使用本地缓存
		if (!$this->useCache) {
			self::$models = [];
			foreach ($this->sort($this->query()->get()) as $model) {
				self::$models[] = $this->createItem($model);
			}
			return self::$models;
		}

		$self = $this;

		self::$models = $this->getLocalCache()->get(
			$this->cacheKey(),
			function () use ($self) {
				$result = [];
				foreach ($this->sort($this->query()->get()) as $model) {
					$result[] = $self->createItem($model);
				}
				return $result;
			});
		return self::$models;
	}

	/**
	 * @param int $id
	 * @return null|stdClass|Model
	 */
	public function findById(int $id)
	{
		foreach ($this->all() as $link) {
			if ($id == $link->id) {
				return $link;
			}
		}
		return null;
	}

	/**
	 * @param int $start
	 * @param int $count
	 * @return Collection
	 */
	public function find(int $start = 0, int $count = PHP_INT_MAX): Collection
	{
		return collect(array_slice($this->all(), $start, $count));
	}

	/**
	 * @return int
	 */
	public function count(): int
	{
		return count($this->all());
	}

	private function getLocalCache(): LocalCache
	{
		return app(LocalCache::class);
	}
}