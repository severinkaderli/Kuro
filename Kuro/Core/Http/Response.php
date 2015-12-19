<?php

namespace Kuro\Core\Http;

/**
 * 
 * 
 * @author  Severin Kaderli <severin.kaderli@gmail.com>
 */
class Response
{
	/**
	 * The HTTP status code for the current response.
	 * 
	 * @var int
	 */
	private $statusCode = 100;

	/**
	 * The response body
	 * 
	 * @var string
	 */
	private $body = "";

	/**
	 * The response headers
	 * 
	 * @var array
	 */
	private $headers = [];

	/**
	 * @return int
	 */
	public function getStatusCode() : int
	{
		return $this->statusCode;
	}

	/**
	 * @param int $statusCode
	 */
	public function setStatusCode(int $statusCode)
	{
		$this->statusCode = $statusCode;
	}

	/**
	 * @return array
	 */
	public function getHeaders() : array
	{
		return $this->headers;
	}

	/**
	 * @param string $header
	 * @param string $value
	 */
	public function setHeader(string $header, string $value)
	{
		$this->headers[$header] = $value; 
	}

	/**
	 * @return string
	 */
	public function getBody() : string
	{
		return $this->body;
	}

	/**
	 * @param string $body
	 */
	public function setBody(string $body)
	{
		$this->body = $body;
	}

	/**
	 * Sends the response to the client.
	 * 
	 * @return void
	 */
	public function send()
	{
		http_response_code($this->getStatusCode());
		foreach($this->getHeaders() as $header => $value) {
			header($header . ": " . $value);
		}
		echo $this->getBody() . "\n";;
	}
}