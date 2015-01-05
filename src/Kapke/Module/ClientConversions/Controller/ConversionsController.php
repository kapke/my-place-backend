<?php
namespace Kapke\Module\ClientConversions\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use Kapke\Module\ClientConversions\Entity\Conversion;

/**
 * @NamePrefix("client_conversions_")
 */
class ConversionsController extends FOSRestController
{
    /**
	 * @Rest\Get("/conversions/{clientId}/{productId}")
	 */
    public function getConversionsAction($clientId, $productId)
    {
        $conversions = $this->getDoctrine()->getRepository('Kapke\\Module\\ClientConversions\\Entity\\Conversion')->findBy([
            'client' => $clientId
          , 'product' => $productId
        ]);
        $view = $this->view($conversions);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("conversions/{clientId}/{productId}")
     */
    public function postConversionsAction($clientId, $productId, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $client = $this->getDoctrine()->getRepository('Kapke\\Provider\\Clients\\Entity\\Client')->find($clientId);
        $product = $this->getDoctrine()->getRepository('Kapke\\Provider\\Clients\\Entity\\product')->find($productId);
        $note = $request->request->get('note');
        $conversion = new Conversion();
        $conversion->setClient($client);
        $conversion->setProduct($product);
        $conversion->setNote($note);
        $em->persist($conversion);
        $em->flush();
        $response = new Response();
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }
}
