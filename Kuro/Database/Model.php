<?php

namespace Kuro\Database;


abstract class Model {


	protected $table;
	protected $_attributes = [
	//TODO: Remove test values
		"name" => null,
		"age" => null
	];

	/**
	 * Get attributes from table
	 */
	public function __construct() {
		//Get properties from database and fill _properties
		//If table property is not set table name = model name
		//e.g. TestModel -> Tablename: Test
	}

	/**
	 * Get an attribute
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getAttribute(string $key) {
		return $this -> _properties[$key];
	}

	/**
	 * Set an attribute
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function setAttribute(string $key, $value) {
		$this -> _properties[$key] = $value;
	}
}