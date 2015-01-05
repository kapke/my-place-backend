<?php
namespace Kapke\Module\Notes\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * @NamePrefix("notes_")
 */
class NotesController
{
    private $crudController;

    public function __construct($crudControllerFactory)
    {
        $entity = 'Kapke\\Provider\\Notes\\Entity\\Note';
        $routePrefix = 'notes';
        $entityName = ['note', 'notes'];
        $this->crudController = $crudControllerFactory->get($entity, $routePrefix, $entityName);
    }

    public function getNotesAction()
    {
        return $this->crudController->getEntitiesAction();
    }

    public function getNoteAction($id)
    {
        return $this->crudController->getEntityAction($id);
    }

    public function postNotesAction(Request $request)
    {
        return $this->crudController->postEntitiesAction($request);
    }

    public function deleteNoteAction($id)
    {
        return $this->crudController->deleteEntityAction($id);
    }

    public function putNoteAction($id, Request $request)
    {
        return $this->crudController->putEntityAction($id, $request);
    }
}
