<?php
namespace Kuro\Exception;

use Exception;

/**
 * Kuro\Exception\PropertyNotDefinedException
 *
 * This exception is thrown when a class property
 * is not defined.
 *
 * @package Kuro\Exception
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class PropertyNotDefinedException extends Exception
{
	/**
	 * @param string $property
	 * @param mixed $class
	 */
	public function __construct(string $property, $class) {
		if(!is_string($class)) {
			$class = get_class($class);
		}

		$message = "Property '" . $property . "' is not defined in class '" . $class . "'";

		parent::__construct($message);
	}
}