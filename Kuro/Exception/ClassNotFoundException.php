<?php
namespace Kuro\Exception;

use Exception;

/**
 * Kuro\Exception\ClassNotFoundException
 *
 * This exception is thrown when a class cannot
 * be found.
 *
 * @package Kuro\Exception
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class ClassNotFoundException extends Exception
{
	/**
	 * @param mixed $class
	 */
	public function __construct($class) {

		if(!is_string($class)) {
			$class = get_class($class);
		}

		$message = "Class '" . $class . "' was not found";

		parent::__construct($message);
	}
}