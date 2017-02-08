<?php

namespace VideoRecruit\Phalcon\OAuth2;

use Nette\Utils\Strings;

/**
 * Class CaseConverter
 *
 * @package VideoRecruit\Phalcon\OAuth2
 */
class CaseConverter
{

	/**
	 * @param array|string $input
	 * @return string|array
	 */
	public static function camelCase($input)
	{
		$output = [];

		if (is_array($input)) {
			foreach ((array) $input as $key => $value) {
				if (is_array($value)) {
					$value = self::camelCase($value);
				}

				$output[self::camelCase($key)] = $value;
			}
		} else {
			$output = Strings::trim(
				Strings::firstLower(Strings::replace($input, '/(_| |-)([a-zA-Z])/', function ($matches) {
					return Strings::upper($matches[2]);
				}))
			);
		}

		return $output;
	}

	/**
	 * @param $input
	 * @return array|string
	 */
	public static function snakeCase($input)
	{
		$output = [];

		if (is_array($input)) {
			foreach ((array) $input as $key => $value) {
				if (is_array($value)) {
					self::snakeCase($value);
				}

				$output[self::snakeCase($key)] = $value;
			}
		} else {
			$output = Strings::trim(
				Strings::lower(
					str_replace([' ', '-'], '_', Strings::replace(ltrim($input, '!'), '/([^_]+[a-z -]{1})([A-Z])/U', '$1_$2'))
				)
			);
		}

		return $output;
	}
}
