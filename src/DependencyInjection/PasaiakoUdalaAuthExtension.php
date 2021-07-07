<?php


namespace PasaiakoUdala\AuthBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PasaiakoUdalaAuthExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container):void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $config = $this->processConfiguration(new Configuration(), $configs);
//        $container->setParameter('msalsas_voting.negative_reasons', $config['negative_reasons']);
//        $container->setParameter('msalsas_voting.anonymous_percent_allowed', $config['anonymous_percent_allowed']);
//        $container->setParameter('msalsas_voting.anonymous_min_allowed', $config['anonymous_min_allowed']);
            $configuration = new Configuration();
            $config = $this->processConfiguration($configuration, $configs);
            foreach ($config as $key => $value) {
                $container->setParameter('pasaikoaudala_auth.' . $key, $value);
            }
    }
}