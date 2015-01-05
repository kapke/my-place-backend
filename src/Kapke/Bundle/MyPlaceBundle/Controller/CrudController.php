<?php
namespace Kapke\Bundle\MyPlaceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class CrudController extends FOSRestController
{
    private $entityManager;
    private $repository;
    private $viewHandler;
    private $Entity;
    private $routesPrefix;
    private $entityName;
    private $entityMetaData;
    private $router;

    public function __construct($entityManager, $viewHandler, $router, $Entity, $prefix, $name)
    {
        $this->entityManager = $entityManager;
        $this->viewHandler = $viewHandler;
        $this->repository = $entityManager->getRepository($Entity);
        $this->router = $router;
        $this->Entity = $Entity;
        $this->routesPrefix = $prefix;
        $this->entityName = $name;
        $this->entityMetaData = $entityManager->getClassMetadata($Entity);
    }

    public function getEntitiesAction()
    {
        $entities = $this->repository->findAll();
        $view = $this->view($entities);

        return $this->handleView($view);
    }

    public function getEntityAction($id)
    {
        $entity = $this->repository->find($id);
        $view = $this->view($entity);

        return $this->handleView($view);
    }

    public function postEntitiesAction(Request $request)
    {
        //print_r($this->entityMetaData);
        $entity = $this->entityMetaData->newInstance();
        $em = $this->entityManager;
        foreach ($this->entityMetaData->fieldNames as $fieldName) {
            if(in_array($fieldName, $this->entityMetaData->identifier)) {
                continue;
            }
            $mapping = $this->entityMetaData->fieldMappings[$fieldName];
            $type = $mapping['type'];
            $value = $request->request->get($fieldName);
            if (is_null($value)) {
                $defaultValue;
                switch ($type) {
                    case 'string':
                        $defaultValue = '';
                        break;
                    case 'integer':
                        $defaultValue = 0;
                        break;

                    default:
                        $defaultValue = false;
                        break;
                }
                if ($defaultValue !== false) {
                    $value = $defaultValue;
                }
            }
            $this->entityMetaData->setFieldValue($entity, $fieldName, $value);
        }
        $em->persist($entity);
        $em->flush();
        $response = new Response();
        $response->headers->set('Location', $this->router->generate($this->getRouteName('GET'), ['id' => $entity->getId()]));
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }

    public function deleteEntityAction($id)
    {
        $response = new Response();
        $em = $this->entityManager;
        $entity = $this->repository->find($id);
        if (!is_null($entity)) {
            $em->remove($entity);
            $em->flush();
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    public function putEntityAction($id, Request $request)
    {
        $em = $this->entityManager;
        $entity = $this->repository->find($id);
        if (!is_null($entity)) {
            foreach ($this->entityMetaData->fieldNames as $fieldName) {
                $mapping = $this->entityMetaData->fieldMappings[$fieldName];
                $type = $mapping['type'];
                $value = $request->request->get($fieldName);
                if (!is_null($value)) {
                    $this->entityMetaData->setFieldValue($entity, $fieldName, $value);
                }
            }
            $em->persist($entity);
            $em->flush();
            $view = $this->view($entity);

            return $this->handleView($view);
        } else {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            return $response;
        }
    }

    public function handleView(View $view)
    {
        return $this->viewHandler->handle($view);
    }

    protected function getRouteName($method, $count=0)
    {
        return $this->routesPrefix.'_'.strtolower($method).'_'.$this->entityName[$count];
    }
}
