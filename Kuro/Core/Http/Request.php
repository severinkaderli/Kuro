<?php
namespace Kuro\Core\Http;

/**
 * 
 * 
 * @author  Severin Kaderli <severin.kaderli@gmail.com>
 */
class Request
{
	/**
	 * The HTTP method of the request
	 * 
	 * @var string
	 */
	private $method;

	/**
	 * The url where the requests points to
	 * 
	 * @var string
	 */
	private $url;

	/**
	 * The data of the request
	 * 
	 * @var string
	 */
	private $data = [];

	/**
	 * The response headers
	 * 
	 * @var array
	 */
	private $headers = [];

	
	public function __construct($url, $method = "GET")
	{
		$this->setUrl($url);
		$this->setMethod($method);
		$this->data = array_merge($_POST, $_GET);
	}

	/**
	 * @return string
	 */
	public function getMethod() : string
	{
		return $this->method;
	}

	/**
	 * @param string $method
	 */
	public function setMethod(string $method)
	{
		$this->method = $method;
	}

	/**
	 * @return string
	 */
	public function getUrl() : string
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl(string $url)
	{
		//Get the base path
		$basePath = str_replace(PROTOCOL . $_SERVER['SERVER_NAME'], "", BASE_DIR);

		//Strip the base path and query string from the request url
        $url = rtrim(str_replace($basePath, "", $url), "/");
        if ($strpos = strpos($url, "?") !== false) {
            $url = substr($url, 0, $strpos);
        }
        if(empty($url)) {
            $url = "/";
        }
		$this->url = $url;
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
	public function getData() : array
	{
		return $this->data;
	}
}