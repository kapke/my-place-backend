<?php
namespace Kapke\Bundle\MyPlaceBundle\Proxy;

use http\Client\Response;

class ResponseParserFactory
{
	private $parsers;

	public function __construct(array $parsers)
	{
		$this->parsers = $parsers;
	}

	public function getParser(Response $response) 
	{	
		$foundParser = null;
		foreach ($this->parsers as $parser) {
			$criteria = $parser['criteria'];
			foreach($criteria as $header => $expectedValue) {
				$actualValue = $response->getHeader($header);
				if(strpos($actualValue, $expectedValue) !== false) {
					$foundParser = $parser;
					break;
				}
			}
			if(!is_null($foundParser)) {
				break;
			}
		}
		if(!isset($parser['instance'])) {
			$Parser = $parser['class'];
			$parser['instance'] = new $Parser();
		}
		return $parser['instance'];
	}
}