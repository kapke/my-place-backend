<?php
namespace Kapke\Bundle\MyPlaceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;


class KapkeMyPlaceExtension extends Extension
{
    
    private $modulesParam = 'kapke_my_place.modules';

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container, 
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');
        foreach ($configs as $config) {
            if (isset($config['module'])) {
                $modules = [];
                if($container->hasParameter($this->modulesParam)) {
                    $modules = $container->getParameter($this->modulesParam);
                }
                $modules[$config['module']['name']] = $config['module'];
                $container->setParameter($this->modulesParam, $modules);
            }
        }
    }
}
