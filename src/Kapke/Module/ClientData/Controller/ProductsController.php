<?php
namespace Kapke\Module\ClientData\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use Kapke\Provider\Clients\Entity\Product;
use Kapke\Provider\Clients\Entity\Vendor;

/**
 * @NamePrefix("client_data_")
 */
class ProductsController extends FOSRestController
{
    private $crudController;
    private $doctrine;
    private $router;

    public function __construct($doctrine, $router, $crudControllerFactory)
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $entity = 'Kapke\\Provider\\Clients\\Entity\\Product';
        $routePrefix = 'client_data';
        $entityName = ['product', 'products'];
        $this->crudController = $crudControllerFactory->get($entity, $routePrefix, $entityName);
    }

    public function getProductsAction()
    {
        return $this->crudController->getEntitiesAction();
    }

    public function getProductAction($id)
    {
        return $this->crudController->getEntityAction($id);
    }

    public function postProductsAction(Request $request)
    {
        $em = $this->doctrine->getManager();
        $vendorRepo = $this->doctrine->getRepository('Kapke\\Provider\\Clients\\Entity\\Vendor');
        $vendor = $vendorRepo->find($request->request->get('vendor'));
        if (!$vendor) {
            $vendor = new Vendor($request->request->get('vendor'));
            $em->persist($vendor);
        }
        $newProduct = new Product($vendor, $request->request->get('name'));
        $em->persist($newProduct);
        $em->flush();
        $response = new Response();
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Location', $this->router->generate('client_data_get_product', ['id' => $newProduct->getId()]));

        return $response;
    }
}
