<?php

declare(strict_types=1);

namespace App;

use Nette;
use Nette\Bootstrap\Configurator;
use Dotenv\Dotenv;
use \Exception;

class Bootstrap
{
	private Configurator $configurator;
	private string $rootDir;

	public function __construct()
	{
		$this->rootDir = dirname(__DIR__);
		$this->configurator = new Configurator;
		$this->configurator->setTempDirectory($this->rootDir . '/temp');
	}

	public function bootWebApplication(): Nette\DI\Container
	{
		$this->initializeEnvironment();
		$this->setupContainer();
		return $this->configurator->createContainer();
	}

	private function defineEnvVariables(): void
	{
		$dotenv = Dotenv::createImmutable($this->rootDir);
		$dotenv->load();

		define('NETTE_ENV', $_ENV['NETTE_ENV'] ?? null);
		define('NETTE_DEBUG', $_ENV['NETTE_DEBUG'] ?? null);
		define('NETTE_DEBUG_IP', $_ENV['NETTE_DEBUG_IP'] ?? null);
	}

	public function initializeEnvironment(): void
	{
		$this->defineEnvVariables();

		if (NETTE_DEBUG === "true") {
			$this->configurator->setDebugMode(true);
		}

		if (NETTE_DEBUG_IP) {
			$this->configurator->setDebugMode(NETTE_DEBUG_IP);
		};

		$this->configurator->enableTracy($this->rootDir . '/log');

		$this->configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();
	}

	private function setupContainer(): void
	{
		$configDir = $this->rootDir . '/config';
		$this->configurator->addConfig($configDir . '/common.neon');
		$this->configurator->addConfig($configDir . '/services.neon');

		$envConfigFile = $this->getEnvConfigFile();

		$this->configurator->addConfig($configDir . "/env/$envConfigFile");
	}

	private function getEnvConfigFile(): string
	{
		return match(NETTE_ENV) {
			"dev" => "dev.neon",
			"prod" => "prod.neon",
			default => throw new Exception(
				"Could not match the value of NETTE_ENV to any config file."
				)
		};
	}
}
