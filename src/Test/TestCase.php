<?php

namespace Kiwi\Core\Test;

use Hamcrest\Util;
use Illuminate\Support\Facades\Event;
use Mockery;

class TestCase extends \Orchestra\Testbench\TestCase
{
	public function setUp(): void
	{
		parent::setUp();
		Util::registerGlobalFunctions();
		Event::fake();
	}

	public function tearDown(): void
	{
		parent::tearDown();
		Mockery::close();
	}

	protected function role(): string
	{
		return "web";
	}

	protected function defineEnvironment($app)
	{
		// for EnvChecker
		$_ENV["ROLE"] = $this->role();

		// app key
		$app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

		// Setup default database to use sqlite :memory:
		$app['config']->set('database.default', 'sqlite');
		$app['config']->set('database.connections.sqlite', [
			'driver' => 'sqlite',
			'database' => ':memory:',
			'prefix' => '',
		]);
	}

	protected function defineDatabaseMigrations()
	{
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
	}

	public function ignorePackageDiscoveriesFrom(): array
	{
		// 允许自动发现
		return [];
	}

	protected function prepareCookiesForJsonRequest(): array
	{
		// 默认需要 return $this->withCredentials ? $this->prepareCookiesForRequest() : [];
		// 不知道为什么. 导致json请求无法带上cookie
		return $this->prepareCookiesForRequest();
	}

	protected function assertApiRes($response, int $status = 0, ?string $message = null)
	{
		$response->assertOk();
		$response->assertJsonPath("status", $status);
		$response->assertJsonPath("message", $message);
	}

//	protected function getPackageProviders($app)
//	{
//		return [KiwiServiceProvider::class];
//	}
}
