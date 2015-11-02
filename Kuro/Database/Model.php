<?php

namespace Kuro\Database;


abstract class Model {


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
	 * Get an property
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getProperty(string $property) {
		if(property_exists($this, $property)) {
			return $this -> $property;
		}
		
		throw new \Exception();
	}

	/**
	 * Set an property
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

		throw new \Exception();
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
	
				echo "Getting " . $property;
				return $this->getProperty($property);

			case 'set':
				
				echo "Setting " . $property;
				$this->setProperty($property, $value);
				return true;	

			case 'has':
				//NOt implemented yet...
				break;
			
			default:
				# code...
				break;
		}


		//TODO: Throw methodnotexist exception
		throw new \Exception();
	}
}