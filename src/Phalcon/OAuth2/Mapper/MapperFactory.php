<?php

namespace VideoRecruit\Phalcon\OAuth2\Mapper;

use VideoRecruit\Phalcon\OAuth2\MappingException;

/**
 * Class MapperFactory
 *
 * @package VideoRecruit\Phalcon\OAuth2\Mapper
 */
class MapperFactory
{
	const JSON = 'application/json';
	const URLENCODED = 'application/x-www-form-urlencoded';
	const MULTIPART = 'multipart/form-data';

	/**
	 * @var array
	 */
	private $mappers = [];

	/**
	 * MapperFactory constructor.
	 */
	public function __construct()
	{
		$this->registerMapper(self::JSON, new JsonMapper());
		$this->registerMapper(self::URLENCODED, new UrlencodedMapper());
		$this->registerMapper(self::MULTIPART, new MultipartMapper());
	}

	/**
	 * @param string $contentType
	 * @param IMapper $mapper
	 * @return self
	 */
	public function registerMapper($contentType, IMapper $mapper)
	{
		$this->mappers[$contentType] = $mapper;

		return $this;
	}

	/**
	 * @param string $contentType
	 * @return IMapper
	 * @throws MappingException
	 */
	public function getMapper($contentType)
	{
		$contentType = explode(';', trim($contentType))[0];
		$contentType = trim($contentType);

		if (!array_key_exists($contentType, $this->mappers)) {
			throw new MappingException(sprintf('There is no mapper for Content-Type: %s.', $contentType));
		}

		return $this->mappers[$contentType];
	}
}
