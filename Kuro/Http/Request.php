<?php
namespace Kuro\Http;

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
	 * Contain the url with the base path stripped away. This url is used
	 * to match routes.
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

	/**
	 * Sets the url and the method of the request. In addition to that
	 * it merges the POST and GET data from the request.
	 * 
	 * @param string $url
	 * @param string $method
	 */
	public function __construct(string $url, string $method = "GET")
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
	 * This sets both, the full url and the short route url.
	 * 
	 * @param string $url
	 */
	public function setUrl(string $url)
	{
		//We remove the query string from the url because
		//it is not needed for this framework
		//Todo: Check how extra data for api calls are gonna be sent...
        if (($strpos = strpos($url, "?")) !== false) {
            $url = substr($url, 0, $strpos);
        }

        //We strip the base path from the request url, so we can match
		//it with the routes. If there's an trailing slash at the end of
		//an url it gets stripped, so we can ensure consistency through all
		//urls.
        $url = rtrim(str_replace(BASE_PATH, "", $url), "/");

        //If the url is empty it's the root route.
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
}