<?php

namespace VideoRecruit\Phalcon\OAuth2;

use OAuth2;

/**
 * Class Configuration
 *
 * @package VideoRecruit\Phalcon\OAuth2
 */
class Configuration
{

	/**
	 * @var array
	 */
	private static $defaults = [
		'dsn' => NULL,
		'username' => NULL,
		'password' => NULL,
		'accessToken' => 'accessToken',
		'lifetime' => 3600,
	];

	/**
	 * @var array
	 */
	private $values = [];

	/**
	 * @var OAuth2\Server
	 */
	private $server;

	/**
	 * @var OAuth2\Storage\Pdo
	 */
	private $storage;

	/**
	 * Configuration constructor.
	 *
	 * @param array $values
	 */
	public function __construct(array $values)
	{
		$this->values = array_merge_recursive(self::$defaults, $values);
	}

	/**
	 * @return OAuth2\Server
	 */
	public function getServer()
	{
		if (!$this->server) {
			$this->server = new OAuth2\Server($this->getStorage(), [
				'allow_implicit' => TRUE,
				'token_param_name' => $this->values['accessToken'],
				'access_lifetime' => $this->values['lifetime'],
			]);

			$this->server->addGrantType(new OAuth2\GrantType\ClientCredentials($this->getStorage()));

			// scope
			$memory = new OAuth2\Storage\Memory([
				'default_scope' => '',
				'supported_scopes' => [],
			]);

			$this->server->setScopeUtil(new OAuth2\Scope($memory));
		}

		return $this->server;
	}

	/**
	 * @return OAuth2\Storage\Pdo
	 */
	private function getStorage()
	{
		if (!$this->storage) {
			$this->storage = new OAuth2\Storage\Pdo([
				'dsn' => $this->values['dsn'],
				'username' => $this->values['username'],
				'password' => $this->values['password'],
			]);
		}

		return $this->storage;
	}
}
