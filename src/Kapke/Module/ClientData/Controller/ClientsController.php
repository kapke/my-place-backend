<?php
namespace Kapke\Module\ClientData\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use Kapke\Provider\Clients\Entity\Client;
use Kapke\Provider\Clients\Entity\Product;

/**
 * @NamePrefix("client_data_")
 */
class ClientsController extends FOSRestController
{
    private $doctrine;
    private $crudController;

    public function __construct($doctrine, $crudControllerFactory)
    {
        $this->doctrine = $doctrine;
        $entity = 'Kapke\\Provider\\Clients\\Entity\\Client';
        $routePrefix = 'client_data';
        $entityName = ['client', 'clients'];
        $this->crudController = $crudControllerFactory->get($entity, $routePrefix, $entityName);
    }

    public function getClientsAction()
    {
        return $this->crudController->getEntitiesAction();
    }

    public function getClientAction($id)
    {
        return $this->crudController->getEntityAction($id);
    }

    public function postClientsAction(Request $request)
    {
        return $this->crudController->postEntitiesAction($request);
    }

    public function deleteClientAction($id)
    {
        return $this->crudController->deleteEntityAction($id);
    }

    public function putClientAction($id, Request $request)
    {
        $em = $this->doctrine->getManager();
        $client = $this->doctrine->getRepository('Kapke\\Provider\\Clients\\Entity\\Client')->find($id);
        $client->setName($request->request->get('name'));
        $client->setSurname($request->request->get('surname'));
        $addedProduct = $request->request->get('addedProduct');
        if ($addedProduct) {
            $product = $this->doctrine->getRepository('Kapke\\Provider\\Clients\\Entity\\Product')->find($addedProduct['id']);
            $client->addProduct($product);
        }
        $em->persist($client);
        $em->flush();
        $view = $this->view($client);

        return $this->crudController->handleView($view);
    }
}
