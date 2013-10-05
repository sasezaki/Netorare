<?php
namespace Netorare\View\Strategy;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\View\ViewEvent;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Renderer\RendererInterface;
use Netorare\View\RendererPluginManager;

class PathinfoExtensionStrategy extends AbstractListenerAggregate
{
    protected $rendererPluginManager;
    protected $defaultRenderer;

    /**
     * Constructor
     *
     * @param  RendererPluginManager $rendererPluginManager
     */
    public function __construct(
        RendererPluginManager $rendererPluginManager, 
        RendererInterface $defaultRenderer,
        ResolverInterface $resolver
    ) {
        $this->rendererPluginManager = $rendererPluginManager;
        $this->defaultRenderer = $defaultRenderer;
        $this->resolver = $resolver;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 100)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    /**
     * Select the Renderer
     *
     * @param  ViewEvent $e
     * @return mixed
     */
    public function selectRenderer(ViewEvent $e)
    {
        $extension = pathinfo($e->getModel()->getTemplate(), PATHINFO_EXTENSION);
        if ($extension) {
            $renderer = $this->rendererPluginManager->get($extension);
            if ($renderer) {
                $renderer->setResolver($this->resolver);
                return $renderer;
            }
        }

        return $this->defaultRenderer;
    }

    /**
     * Populate the response object from the View
     *
     * Populates the content of the response object from the view rendering
     * results.
     *
     * @param ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->defaultRenderer) {
            return;
        }

        $result   = $e->getResult();
        $response = $e->getResponse();

        $response->setContent($result);
    }
}
