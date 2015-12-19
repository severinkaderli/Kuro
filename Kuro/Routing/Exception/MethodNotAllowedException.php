<?php

namespace Kuro\Routing\Exception;

use Exception;

/**
 * Kuro\Routing\Exception\MethodNotAllowedException
 *
 * This exception is thrown when a not allowed
 * method is used in the router.
 *
 * @package Kuro\Routing\Exception
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class MethodNotAllowedException extends Exception
{
	/**
	 * @param string $method
	 */
	public function __construct(string $method) {

		$message = $method . " is not an allowed method";

		parent::__construct($message);
	}
}