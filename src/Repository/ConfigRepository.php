<?php

namespace Kiwi\Core\Repository;


use Illuminate\Database\Eloquent\Builder;
use Kiwi\Core\Model\Config;
use stdClass;

class ConfigRepository extends BaseRepository
{
	protected function query(): ?Builder
	{
		return Config::query();
	}

	/**
	 * @param string $name
	 * @return Config|null
	 */
	public function findByName(string $name): ?Config
	{
		return $this->query()->where("name", $name)->first();
	}

	/**
	 * @param string $name
	 * @return int|string|array|stdClass|null
	 */
	public function findValueByName(string $name): int|string|array|stdClass|null
	{
		$config = $this->findByName($name);
		if (empty($config)) {
			return null;
		}

		if ($config->type === Config::TYPE_INT) {
			return (int)$config->value;
		}
		if ($config->type === Config::TYPE_STRING) {
			return (string)$config->value;
		}
		if ($config->type === Config::TYPE_JSON) {
			return json_decode($config->value);
		}
		return $config->value;
	}

	public function save(Config $config): bool
	{
		return $config->save();
	}
}