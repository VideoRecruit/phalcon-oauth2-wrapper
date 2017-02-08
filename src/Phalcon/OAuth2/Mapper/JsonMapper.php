<?php

namespace VideoRecruit\Phalcon\OAuth2\Mapper;

/**
 * Class JsonMapper
 *
 * @package VideoRecruit\Phalcon\OAuth2\Mapper
 */
class JsonMapper implements IMapper
{

	/**
	 * @param string $data
	 * @return array
	 */
	public function parse($data)
	{
		return json_decode($data, TRUE);
	}
}
