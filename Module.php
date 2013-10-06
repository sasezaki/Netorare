<?php
namespace Netorare;

use Netorare\View\Strategy\PathinfoExtensionStrategy;
use Netorare\View\RendererPluginManager;

class Module
{
    public function onBootstrap($event)
    {
        // @todo
        if (isset($compile)) {
            $em = $event->getApplication()->getEventManager();
            $em->attachAggregate(new RequestRouteCompileListener);
        }
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'NetorareRendererPluginManager' => function($sm) {
                    $manager = new RendererPluginManager();
                    $manager->setService('phtml', $sm->get('ViewRenderer'));
                    return $manager;
                },
                'NetorarePathinfoExtensionStrategy' => function($sm) {
                    $manager = $sm->get('NetorareRendererPluginManager');
                    return new PathinfoExtensionStrategy($manager, $sm->get('ViewRenderer'), $sm->get('ViewResolver'));
                }
            ],
            'invokables' => [
                'Michelf\Markdown' => 'Michelf\Markdown',
            ]
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
