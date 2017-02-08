<?php

namespace VideoRecruit\Phalcon\OAuth2\Mapper;

/**
 * Interface IMapper
 *
 * @package VideoRecruit\Phalcon\OAuth2\Mapper
 */
interface IMapper
{

	/**
	 * @param string $data
	 * @return array
	 */
	function parse($data);
}
