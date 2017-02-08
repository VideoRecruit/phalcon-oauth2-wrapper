<?php

namespace VideoRecruit\Phalcon\OAuth2;

use Nette\Utils\Json;
use OAuth2;
use Phalcon\Http\Request as HttpRequest;

/**
 * Class Wrapper
 *
 * @package VideoRecruit\Phalcon\OAuth2
 */
class Wrapper
{

	/**
	 * @var Configuration
	 */
	private $configuration;

	/**
	 * @var Mapper\MapperFactory
	 */
	private $mapperFactory;

	/**
	 * @var array
	 */
	private $request;

	/**
	 * @param Configuration $configuration
	 * @param Mapper\MapperFactory $mapperFactory
	 * @param HttpRequest $httpRequest
	 */
	public function __construct(Configuration $configuration, Mapper\MapperFactory $mapperFactory, HttpRequest $httpRequest)
	{
		$this->configuration = $configuration;
		$this->mapperFactory = $mapperFactory;
		$this->request = $this->createRequest($httpRequest);
	}

	/**
	 * @return AccessToken
	 * @throws AuthenticationException
	 */
	public function handleToken()
	{
		$response = $this->configuration->getServer()->handleTokenRequest($this->request);

		// create access token object on success
		if ($response->getParameter('error') === NULL) {
			return AccessToken::fromJSON($response->getResponseBody());
		}

		throw new AuthenticationException;
	}

	/**
	 * @return bool
	 */
	public function isAuthorized()
	{
		return $this->configuration->getServer()
			->verifyResourceRequest($this->request, NULL, NULL);
	}

	/**
	 * @return string
	 */
	public function getClientId()
	{
		$token = $this->configuration->getServer()
			->getAccessTokenData($this->request);

		return $token['client_id'];
	}

	/**
	 * Creates OAuth2 request from the Http request.
	 *
	 * @param HttpRequest $httpRequest
	 * @return OAuth2\Request
	 */
	protected function createRequest(HttpRequest $httpRequest)
	{
		$get = CaseConverter::snakeCase($_GET);
		$post = CaseConverter::snakeCase($_POST);
		$body = trim($httpRequest->getRawBody());
		$contentType = $httpRequest->getHeader('Content-Type');

		if (!empty($body) && !empty($contentType)) {
			$mapper = $this->mapperFactory->getMapper($contentType);
			$post = $mapper->parse($body);
		}

		return new OAuth2\Request($get, $post, [], $_COOKIE, $_FILES, $_SERVER);
	}
}
