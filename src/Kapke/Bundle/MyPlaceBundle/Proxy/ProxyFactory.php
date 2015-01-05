<?php
namespace Kapke\Bundle\MyPlaceBundle\Proxy;

class ProxyFactory
{
	private $parserFactory;

	public function __construct(ResponseParserFactory $parserFactory)
	{
		$this->parserFactory = $parserFactory;
	}

	public function getProxy(array $url, array $headers = null)
	{
		$proxy = new Proxy($this->parserFactory);
		$proxy->setUrl($url);
		if(!is_null($headers)) {
			$proxy->setHeaders($headers);	
		}
		return $proxy;
	}
}