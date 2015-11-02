<?php
namespace Kuro\Exception;

use Exception;

/**
 * Kuro\Exception\ClassNotFoundException
 *
 * This is exception is thrown when a class cannot
 * be found.
 *
 * @package Kuro\Exception
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class ClassNotFoundException extends Exception
{
	public function __construct($class) {

		$message = "Class '" . getClass($class) . "' was not found";

		parent::__construct();
	}
}