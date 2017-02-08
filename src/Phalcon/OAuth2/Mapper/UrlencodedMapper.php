<?php

namespace VideoRecruit\Phalcon\OAuth2\Mapper;

/**
 * Class UrlencodedMapper
 *
 * @package VideoRecruit\Phalcon\OAuth2\Mapper
 */
class UrlencodedMapper implements IMapper
{

	/**
	 * @param string $data
	 * @return array
	 */
	public function parse($data)
	{
		$values = [];

		parse_str($data, $values);

		return $values;
	}
}
