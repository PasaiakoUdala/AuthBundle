<?php


namespace PasaiakoUdala\AuthBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {

        $treeBuilder = new TreeBuilder('pasaiakoudala_auth');

        $treeBuilder->getRootNode()
            ->children()
//                ->scalarNode('LDAP_IP')->defaultValue('IP')->end()
//                ->scalarNode('LDAP_BASE_DN')->defaultValue('DC=DOMAIN,DC=net')->end()
//                ->scalarNode('LDAP_SEARCH_DN')->defaultValue('CN=LDAPUSER,CN=Users,DC=pasaia,DC=net')->end()
//                ->scalarNode('LDAP_PASSWD')->defaultValue('passwd')->end()
                ->scalarNode('LDAP_ADMIN_TALDEAK')->defaultValue('LDAP_TALDEA')->end()
                ->scalarNode('LDAP_KUDEATU_TALDEAK')->defaultValue('LDAP_TALDEA')->end()
                ->scalarNode('LDAP_USER_TALDEA')->defaultValue('LDAP_TALDEA')->end()
                ->scalarNode('route_after_successfull_login')->defaultValue('default')->end()
            ->end();

        return $treeBuilder;
    }
}