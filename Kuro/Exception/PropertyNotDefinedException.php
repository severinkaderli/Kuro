<?php
namespace Kuro\Exception;

use Exception;

/**
 * Kuro\Exception\PropertyNotDefinedException
 *
 * This is exception is thrown when a class property
 * is not defined.
 *
 * @package Kuro\Exception
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class PropertyNotDefinedException extends Exception
{
	public function __construct($property, $class) {
		$message = "Property '" . $property . "' is not defined in class '" . get_class($class) . "'";

		parent::__construct($message);
	}
}