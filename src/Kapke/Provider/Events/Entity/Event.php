<?php
namespace Kapke\Provider\Events\Entity;

class Event {
	use \Kapke\Bundle\MyPlaceBundle\DependencyInjection\Serializer;
	protected $serializableProperties;

	private $id;
	private $name;
	private $address;
	private $time;
	private $agenda;

	public function __construct()
	{
		$that = $this;
		$this->serializableProperties = [
			['name' => 'id'],
			['name' => 'name'],
			['name' => 'address'],
			['name' => 'agenda'],
			[
				'name' => 'time',
				'value' => function () use ($that) {
					return $that->time->getTimestamp();
				}
			]
		];
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name) 
	{
		$this->name = $name;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function setAgenda($agenda)
	{
		$this->agenda = $agenda;
	}

	public function getAgenda()
	{
		return $this->agenda;
	}

	public function setDateAndTime($date, $time)
	{
		$date = explode('-', $date);
		$time2 = substr($time, 0, strlen($time)-5);
		$time2 = \DateTime::createFromFormat('Y-m-d\TH:i:s', $time2);
		$time2->setDate($date[0], $date[1], $date[2]);
		$this->time = $time2;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function setAddress($address)
	{
		$this->address = $address;
	}
}