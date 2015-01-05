<?php

namespace Kapke\Bundle\MyPlaceBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;

use FOS\RestBundle\View\View;

use Kapke\Bundle\MyPlaceBundle\DependencyInjection\Serializer;

class ModulesController extends FOSRestController
{
    private $modulesManager;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->modulesManager = $this->get('kapke_my_place.modules_manager');
    }

    public function getModulesAction()
    {
        $modules = Serializer::serializeArray(array_values($this->modulesManager->getModules(true)));
        // $modules = array_map(function ($module) {
        //     return $module->jsonSerialize();
        // }, array_values($this->modulesManager->getModules(true)));
        $view = $this->view($modules);

        return $this->handleview($view);
    }

    public function getModuleAction($name)
    {
        $module = $this->modulesManager->getModule($name);

        return $this->handleview($this->view($module));
    }
}
