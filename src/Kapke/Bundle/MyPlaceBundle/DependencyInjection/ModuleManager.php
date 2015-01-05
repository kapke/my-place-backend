<?php
namespace Kapke\Bundle\MyPlaceBundle\DependencyInjection;

class ModuleManager
{
    private $modules;
    private $moduleTree;

    public function __construct($modules)
    {
        $this->moduleTree = null;
        $this->modules = array_map(function ($module) {
            return new Module($module);
        }, $modules);
    }

    public function buildTree()
    {
        $moduleDictionary = [];
        $output = [];
        foreach ($this->modules as $module) {
            $moduleDictionary[$module->getName()] = $module;
        }
        foreach ($this->modules as $module) {
            if ($module->hasParent()) {
                $moduleDictionary[$module->getParent()]->addChild($module);
            } else {
                $output[] = $module;
            }
        }
        $this->moduleTree = $output;
    }

    public function getModules($tree = false)
    {
        if ($tree) {
            if ($this->moduleTree == null) {
                $this->buildTree();
            }

            return $this->moduleTree;
        } else {
            return $this->modules;
        }

    }

    public function getModule($name)
    {
        return $this->modules[$name];
    }

}
