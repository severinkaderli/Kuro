<?php

namespace Kuro\Routing\Exception;

use Exception;

/**
 * Kuro\Routing\Exception\IllegalCallbackException
 *
 * This exception is thrown when a not allowed
 * method is used in the router.
 *
 * @package Kuro\Routing\Exception
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class IllegalCallbackException extends Exception
{

	public function __construct() {

		$message = "No callback method was specified! Expected format is: Controller@method";

		parent::__construct($message);
	}
}