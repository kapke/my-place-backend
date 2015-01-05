<?php
namespace Kapke\Bundle\MyPlaceBundle\Controller;

class CrudControllerFactory
{
    private $entityManager;
    private $viewHandler;
    private $validator;
    private $router;

    public function __construct($entityManager, $viewHandler, $router)
    {
        $this->entityManager = $entityManager;
        $this->viewHandler = $viewHandler;
        $this->router = $router;
    }

    public function get($entity, $prefix, $name)
    {
        return new CrudController($this->entityManager, $this->viewHandler, $this->router, $entity, $prefix, $name);
    }
}
