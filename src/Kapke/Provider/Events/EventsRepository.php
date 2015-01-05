<?php
namespace Kapke\Provider\Events;

use Kapke\Bundle\MyPlaceBundle\Base\ReadRepository;
use Kapke\Bundle\MyPlaceBundle\Proxy\ProxyFactory;
use Kapke\Provider\Events\Entity\Event;

class EventsRepository implements ReadRepository 
{
	private $proxy;

	public function __construct(ProxyFactory $proxyFactory)
	{	
		$this->proxy = $proxyFactory->getProxy([
			'base' => 'http://meetspace.it',
			'resource' => '/api/localevents'
		], [
			'Accept' => 'application/json',
			'Authorization' => 'Token token=cbcea83304154aa51be1696205a3f384'
		]);
	}

	public function findAll()
	{
		return array_map(
			[$this, 'create'], 
			$this->proxy->get());
	}

	public function findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
	{
		$result = array_map(
			[$this, 'create'], 
			$this->proxy->get($criteria));

		return $result;
	}

	public function create(array $data = null)
	{
		$event = new Event();
		$event->setId($data['id']);
		$event->setName($data['name']);
		$event->setDateAndTime($data['date'], $data['time']);
		$event->setAddress($data['address']);
		$event->setAgenda($data['agenda']);
		
		return $event;
	}
}