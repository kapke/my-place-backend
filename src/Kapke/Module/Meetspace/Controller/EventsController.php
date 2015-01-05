<?php
namespace Kapke\Module\Meetspace\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Kapke\Provider\Clients\Entity\Vendor;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use Kapke\Bundle\MyPlaceBundle\Base\ReadRepository;
use FOS\RestBundle\View\View;
use Kapke\Bundle\MyPlaceBundle\DependencyInjection\Serializer;

/**
 * @NamePrefix("meetspace_")
 */
class EventsController extends FOSRestController 
{
	private $eventsRepository;
	private $viewHandler;

	public function __construct(ReadRepository $repository, $viewHandler)
	{
		$this->eventsRepository = $repository;
		$this->viewHandler = $viewHandler;
	}

	public function getEventsAction(Request $request)
	{
		$city = $request->query->has('city')?$request->query->get('city'):false;
		$events;
		if($city) {
			$events = $this->eventsRepository->findBy(['city' => $city]);
		} else {
			$events = $this->eventsRepository->findAll();
		}
		return $this->handleView(
			$this->view(Serializer::serializeArray($events))
		);
	}

	public function handleView(View $view)
	{
		return $this->viewHandler->handle($view);
	}
}