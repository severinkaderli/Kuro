<?php
namespace Kuro\Exception;

use Exception;

/**
 * Kuro\Exception\MethodNotFoundException
 *
 * This exception is thrown when a class method
 * cannot be found.
 *
 * @package Kuro\Exception
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class MethodNotFoundException extends Exception
{
	/**
	 * @param string $method
	 * @param object $class
	 */
	public function __construct(string $method, $class) {
		if(!is_string($class)) {
			$class = get_class($class);
		}

		$message = "Method '" . $method . "' was not found in class '" . $class . "'";

		parent::__construct($message);
	}
}