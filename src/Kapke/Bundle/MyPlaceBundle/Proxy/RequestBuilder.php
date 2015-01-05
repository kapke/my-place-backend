<?php
namespace Kapke\Bundle\MyPlaceBundle\Proxy;

use http\Client\Request;
use http\QueryString;

class RequestBuilder {
	const GET_METHOD = 'GET';
	const POST_METHOD = 'POST';
	const DELETE_METHOD = 'DELETE';
	const PUT_METHOD = 'PUT';

	private $method = self::GET_METHOD;
	private $base;
	private $resource;
	private $pathParams;
	private $params = [];
	private $headers = [];

	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function setBase($base)
	{
		$this->base = $base;
	}

	public function setResource($resource)
	{
		$this->resource = $resource;
	}

	public function setPathParams($pathParams)
	{
		$this->pathParams = $pathParams;
	}

	public function setParams($params)
	{
		$this->params = $params;
	}

	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
	}

	public function getRequest()
	{
		$url = $this->buildUrl();
		$request = new Request($this->method, $url['address'], $this->headers);
		$request->setQuery($url['query']);

		return $request;
	}

	protected function buildUrl()
	{
		$url = $this->base.$this->resource;
		$pathParams = [];
		$queryParams = $this->params;
		foreach ($this->pathParams as $param) {
			if(isset($queryParams[$param])) {
				$pathParams[] = $queryParams[$param];
				unset($queryParams[$param]);
			} else {
				break;
			}
		}
		$url .= '/'.join('/', $pathParams);
		$queryString = new QueryString();
		foreach($queryParams as $key => $val) {
			$queryString[$key] = $val;
		}

		return [
			'address' => $url,
			'query' => $queryString
		];
	}
}