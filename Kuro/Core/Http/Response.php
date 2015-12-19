<?php

namespace Kuro\Core\Http;

/**
 * 
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
	private $body;

	/**
	 * The response headers
	 * 
	 * @var array
	 */
	private $headers = [];

	/**
	 * @param int $statusCode
	 * @param string $content
	 * @param array $headers
	 */
	public function __construct(int $statusCode, string $body, array $headers)
	{
		$this->statusCode = $statusCode;
		$this->body = $body;
		$this->headers = $headers;
	}

	/**
	 * @return int
	 */
	public function getStatusCode() : int
	{
		return $this->statusCode;
	}

	/**
	 * @return array
	 */
	public function getHeaders() : array
	{
		return $this->headers;
	}

	/**
	 * @return string
	 */
	public function getBody() : string
	{
		return $this->body;
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