<?php

namespace VideoRecruit\Phalcon\OAuth2;

use Nette\Utils\Json;

/**
 * Class AccessToken
 *
 * @package VideoRecruit\Phalcon\OAuth2
 */
class AccessToken
{

	/** @var string */
	private $token;

	/** @var int */
	private $expireInterval;

	/** @var string */
	private $type;

	/** @var string */
	private $scope;

	/** @var array */
	private $data;

	/**
	 * AccessToken constructor.
	 *
	 * @param array $values
	 */
	public function __construct(array $values)
	{
		$this->token = $values['access_token'];
		$this->expireInterval = $values['expires_in'];
		$this->type = $values['token_type'];
		$this->scope = $values['scope'];

		$this->data = $values;
	}

	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @return int
	 */
	public function getExpireInterval()
	{
		return $this->expireInterval;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getScope()
	{
		return $this->scope;
	}

	/**
	 * @param bool $camelCase
	 * @return array
	 */
	public function toArray($camelCase = TRUE)
	{
		return $camelCase ? CaseConverter::camelCase($this->data) : $this->data;
	}

	/**
	 * Factory method to create AccessToken object from json content.
	 *
	 * @param string $data
	 * @return AccessToken
	 */
	public static function fromJSON($data)
	{
		return new self(Json::decode($data, Json::FORCE_ARRAY));
	}
}
