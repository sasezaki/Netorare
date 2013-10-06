<?php
namespace Netorare;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class RequestRouteCompileListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $events->attach(MvcEvent::EVENT_FINISH, function($e) {
            if ($match = $e->getRouteMatch()) {
                $params = $match->getParams();
                if (isset($params['template'])) {
                    $path = getcwd().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$match->getMatchedRouteName().'.html';
                    file_put_contents($path, $e->getResponse()->getContent());
                }
            }
        }, -10);
    }
}
