<?php
namespace Kapke\Bundle\MyPlaceBundle\Base;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Kapke\Bundle\MyPlaceBundle\DependencyInjection\Configuration;
use Kapke\Bundle\MyPlaceBundle\DependencyInjection\KapkeMyPlaceExtension;

abstract class ModuleExtension extends Extension
{
    private $dir;

    public function __construct()
    {
        $reflectionClass = new \ReflectionClass($this);
        $this->dir = dirname($reflectionClass->getFileName());
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $kapkeMyPlaceExtension = new KapkeMyPlaceExtension();
        $container->registerExtension($kapkeMyPlaceExtension);
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->loadModuleDefinition($container);
        $kapkeMyPlaceExtension->load($container->getExtensionConfig($kapkeMyPlaceExtension->getAlias()), $container);
    }

    protected function loadModuleDefinition($container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator($this->dir.'/../Resources/config'));
        $loader->load('module.yml');
        $loader->load('services.yml');
    }
}
