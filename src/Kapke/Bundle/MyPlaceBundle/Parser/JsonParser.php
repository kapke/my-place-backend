<?php
namespace Kapke\Bundle\MyPlaceBundle\Parser;

use Kapke\Bundle\MyPlaceBundle\Base\Parser;

class JsonParser implements Parser 
{
	public function parse($content)
	{
		return json_decode($content, true);
	}
}