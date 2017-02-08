<?php

namespace VideoRecruit\Phalcon\OAuth2\DI;

use VideoRecruit\Phalcon\OAuth2\Configuration;
use VideoRecruit\Phalcon\OAuth2\InvalidArgumentException;
use VideoRecruit\Phalcon\OAuth2\Mapper\MapperFactory;
use VideoRecruit\Phalcon\OAuth2\Wrapper;
use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Class OAuth2WrapperExtension
 *
 * @package VideoRecruit\Phalcon\OAuth2\DI
 */
class OAuth2WrapperExtension
{
	const REQUEST = 'request';

	const CONFIGURATION = 'videorecruit.phalcon.oauth2.configuration';
	const WRAPPER = 'videorecruit.phalcon.oauth2.wrapper';
	const MAPPER_FACTORY = 'videorecruit.phalcon.oauth2.mapperFactory';

	/**
	 * @var DiInterface
	 */
	private $di;

	/**
	 * Oauth2WrapperExtension constructor.
	 *
	 * @param DiInterface $di
	 * @param array|Config $config
	 * @throws InvalidArgumentException
	 */
	public function __construct(DiInterface $di, $config)
	{
		$this->di = $di;

		if ($config instanceof Config) {
			$config = $config->toArray();
		} elseif (!is_array($config)) {
			throw new InvalidArgumentException('Config has to be either an array or ' .
				'a phalcon config instance.');
		}

		$this->di->setShared(self::CONFIGURATION, function () use ($config) {
			return new Configuration($config);
		});

		$this->di->setShared(self::WRAPPER, function () {
			return new Wrapper(
				$this->get(self::CONFIGURATION),
				$this->get(self::MAPPER_FACTORY),
				$this->get(self::REQUEST)
			);
		});

		$this->di->setShared(self::MAPPER_FACTORY, function () {
			return new MapperFactory();
		});
	}

	/**
	 * Register extension services into Phalcon's di container.
	 *
	 * @param DiInterface $di
	 * @param array|Config $config
	 * @return self
	 */
	public static function register(DiInterface $di, $config = NULL)
	{
		return new self($di, $config ?: []);
	}
}
