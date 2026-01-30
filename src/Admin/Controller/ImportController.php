<?php


namespace Kiwi\Core\Admin\Controller;


use Illuminate\Routing\Controller;
use Kiwi\Core\Admin\Service\ImportService;

class ImportController extends Controller
{
	protected ImportService $service;

	public function __construct(ImportService $service)
	{
		$this->service = $service;
	}

	public function import(string $type): array
	{
		$this->service->import(request()->file('file'), $type);
		return [];
	}
}