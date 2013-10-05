<?php
namespace Netorare\View;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\View\Renderer\RendererInterface;

class RendererPluginManager extends AbstractPluginManager
{
    protected $invokableClasses = array(
        'md'       => 'Netorare\View\Renderer\MarkdownRenderer',
        'markdown' => 'Netorare\View\Renderer\MarkdownRenderer',
    );

    public function validatePlugin($plugin)
    {
        if ($plugin instanceof RendererInterface) {
            // we're okay
            return;
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Plugin of type %s is invalid; must implement Zend\View\Renderer\RendererInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin))
        ));
    }
}
