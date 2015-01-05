<?php
namespace Kapke\Module\ClientData\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Kapke\Provider\Clients\Entity\Vendor;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * @NamePrefix("client_data_")
 */
class VendorsController extends FOSRestController
{
    private $crudController;

    public function __construct($crudControllerFactory)
    {
        $entity = 'Kapke\\Provider\\Clients\\Entity\\Vendor';
        $routePrefix = 'client_data';
        $entityName = ['vendor', 'vendors'];
        $this->crudController = $crudControllerFactory->get($entity, $routePrefix, $entityName);
    }

    public function getVendorsAction()
    {
        return $this->crudController->getEntitiesAction();
    }

    public function getVendorAction($id)
    {
        return $this->crudController->getEntityAction($id);
    }

    public function postVendorsAction(Request $request)
    {
        return $this->crudController->postEntitiesAction($request);
    }
}
