<?php
namespace Kapke\Bundle\MyPlaceBundle\Proxy;

use http\Client;
use http\Client\Request;
use http\Client\Response;

class Proxy
{
	private $base;
	private $resource;
	private $headers = [];
	private $pathParams = [];

	private $parserFactory;
	private $client;
	

	public function __construct(ResponseParserFactory $parserFactory)
	{
		$this->parserFactory = $parserFactory;
		$this->client = new Client();
	}

	public function setUrl(array $url)
	{
		$this->base = $url['base'];
		$this->resource = $url['resource'];
		if(isset($url['pathParams'])) {
			$this->pathParams = $url['pathParams'];
		}
	}

	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
	}

	public function get(array $criteria = null)
	{
		$requestBuilder = new RequestBuilder();
		$requestBuilder->setMethod(RequestBuilder::GET_METHOD);
		$requestBuilder->setBase($this->base);
		$requestBuilder->setResource($this->resource);
		$requestBuilder->setPathParams($this->pathParams);
		$requestBuilder->setHeaders($this->headers);
		if(!is_null($criteria)) {
			$requestBuilder->setParams($criteria);	
		}
		
		$request = $requestBuilder->getRequest();

		return $this->makeRequest($request);
	}

	public function makeRequest(Request $request)
	{
		$this->client->enqueue($request)->send();
		$response = $this->client->getResponse();

		return $this->handleResponse($response);
	}

	protected function handleResponse(Response $response)
	{
		$parser = $this->parserFactory->getParser($response);
		$output = $parser->parse($response->getBody()->toString());
		return $output;
	}


}