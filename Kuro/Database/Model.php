<?php

namespace Kuro\Database;

use Kuro\Exception\MethodNotFoundException;
use Kuro\Exception\PropertyNotDefinedException;

class Model {


	protected $table;
	private $properties = [];

	/**
	 * Get attributes from table
	 */
	public function __construct() {
		//Get properties from database and fill _properties
		//If table property is not set table name = model name
		//e.g. TestModel -> Tablename: Test
		$tmpProperties = ["age", "name"];
		foreach($tmpProperties as $property) {
			array_push($this->properties, $property);
			$this->$property = null;
		}
	}

	/**
	 * Get a property
	 *
	 * @param string $key
	 * @return mixed
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
	 *
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