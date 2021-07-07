<?php


namespace PasaiakoUdala\AuthBundle\DependencyInjection;


use PasaiakoUdala\AuthBundle\Security\FormLoginAuthenticator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use PasaiakoUdala\AuthBundle\Service\PasaiaLdapService;

class PasaiakoUdalaAuthExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container):void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $config = $this->processConfiguration(new Configuration(), $configs);
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        foreach ($config as $key => $value) {
            $container->setParameter('pasaiako_udala_auth.' . $key, $value);
        }
        $definition = $container->getDefinition(PasaiaLdapService::class);
        $definition->setArgument(4, $config['LDAP_ADMIN_TALDEAK']);
        $definition->setArgument(5, $config['LDAP_KUDEATU_TALDEAK']);
        $definition->setArgument(6, $config['LDAP_USER_TALDEA']);
        $def = $container->getDefinition('paud.form.auth');
        $def->setArgument(3, $config['route_after_successfull_login']);
    }
}