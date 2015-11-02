<?php

namespace Kuro\Database;

use Kuro\Exception\MethodNotFoundException;
use Kuro\Exception\PropertyNotDefinedException;

/**
 * Kuro\Database\Model
 *
 * This is the base model class which all model are
 * inherited from.
 *
 * @package Kuro\Database
 * @author Severin Kaderli <severin.kaderli@gmail.com>
 */
class Model {

	/**
	 * The database table which this model belongs to. If it's
	 * not set the model name is used as table name.
	 * @var $table
	 */
	protected $table;

	/**
	 * Get attributes from table
	 */
	public function __construct() {
		//TODO: Remove this tmp data
		$tmpProperties = ["age", "name"];
		foreach($tmpProperties as $property) {
			$this->$property = null;
		}
	}

	/**
	 * Get a property
	 *
	 * @param string $key
	 * @return mixed
	 *
	 * @throws PropertyNotDefinedException
	 */
	public function getProperty(string $property) {
		if(property_exists($this, $property)) {
			return $this -> $property;
		}
		
		throw new PropertyNotDefinedException($property, $this);
	}

	/**
	 * Set a property
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return bool
	 *
	 * @throws PropertyNotDefinedException
	 */
	public function setProperty(string $property, $value) {
		if(property_exists($this, $property)) {
			$this->$property = $value;

			return true;
		}

		throw new PropertyNotDefinedException($property, $this);
	}

	/**
	 * Check if a property exists
	 *
	 * @param string $property
	 * @return bool
	 */
	public function hasProperty(string $property) {
		return property_exists($this, $property);
	}

	/**
	 * We check to see if a property was accessed using
	 * a dynamic method. We then route the method calls
	 * to the corresponding internal methods.
	 *
	 * @param string $method 
	 * @param array $params
	 * 
	 * @throws PropertyNotDefinedException
	 */
	public function __call($method, $params) {

		//Name of the property
		$property = strToLower(substr($method, 3));
		$methodType = substr($method, 0, 3);

		//TODO: Checking value params better
		$value = isset($params[0]) ? $params[0] : null;


		switch ($methodType) {
			case 'get':
				return $this->getProperty($property);

			case 'set':
				$this->setProperty($property, $value);
				return true;	

			case 'has':
				return $this->hasProperty($property);
			
			default:
				break;
		}

		throw new MethodNotFoundException($method, $this);
	}
}