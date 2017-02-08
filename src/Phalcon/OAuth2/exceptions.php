<?php

namespace VideoRecruit\Phalcon\OAuth2;


use Exception;

interface IException
{

}



/**
 * The exception that is thrown when the value of an argument is
 * outside the allowable range of values as defined by the invoked method.
 */
class ArgumentOutOfRangeException extends \InvalidArgumentException implements IException
{

}



/**
 * The exception that is thrown when a method call is invalid for the object's
 * current state, method has been invoked at an illegal or inappropriate time.
 */
class InvalidStateException extends \RuntimeException implements IException
{

}



/**
 * The exception that is thrown when a requested method or operation is not implemented.
 */
class NotImplementedException extends \LogicException implements IException
{

}



/**
 * The exception that is thrown when an invoked method is not supported. For scenarios where
 * it is sometimes possible to perform the requested operation, see InvalidStateException.
 */
class NotSupportedException extends \LogicException implements IException
{

}



/**
 * The exception that is thrown when an argument does not match with the expected value.
 */
class InvalidArgumentException extends \InvalidArgumentException implements IException
{

}



/**
 * The exception that is thrown when an illegal index was requested.
 */
class OutOfRangeException extends \OutOfRangeException implements IException
{

}



/**
 * The exception that is thrown when a value (typically returned by function) does not match with the expected value.
 */
class UnexpectedValueException extends \UnexpectedValueException implements IException
{

}



/**
 * The exception is thrown when there is no available mapper for requested Content-Type.
 */
class MappingException extends InvalidStateException
{

}



/**
 * This exception is thrown when invalid credentials has been given
 * and it's not possible to generate valid access token.
 */
class AuthenticationException extends InvalidStateException
{

}
