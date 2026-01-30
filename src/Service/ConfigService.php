<?php


namespace Kiwi\Core\Service;


use Kiwi\Core\Model\Config;
use Kiwi\Core\Repository\ConfigRepository;
use stdClass;

class ConfigService
{
	private ConfigRepository $repository;

	public function __construct(ConfigRepository $repository)
	{
		$this->repository = $repository;
	}

	public function get(string $name): int|string|array|stdClass|null
	{
		return $this->repository->findValueByName($name);
	}

	public function set(string $name, $value, string $type = ""): void
	{
		$config = $this->repository->findByName($name);
		if (empty($config)) {
			$config = new Config();
			$config->name = $name;
			$config->type = $type;
		}
		$config->value = $value;
		$this->repository->save($config);
	}

	public function fetch(string $name): ?Config
	{
		return $this->repository->findByName($name);
	}
}