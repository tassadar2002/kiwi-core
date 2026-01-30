<?php


namespace Kiwi\Core\Service;


use Illuminate\Support\Collection;
use Kiwi\Core\Model\Element;
use Kiwi\Core\Repository\ElementRepository;

class ElementService
{
	/**
	 * @var
	 */
	private ElementRepository $repository;

	public function __construct(ElementRepository $repository)
	{
		$this->repository = $repository;
	}

	public function get(string $name): ?Element
	{
		return $this->repository->findByName($name);
	}

	public function find(string $parent): Collection
	{
		return $this->repository->findByParent($parent);
	}
}