<?php
namespace Netorare\View\Renderer;

use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface as Resolver;
use Zend\View\Resolver\TemplatePathStack;

class MarkdownRenderer implements RendererInterface
{
    /**
     * Template resolver
     *
     * @var Resolver
     */
    private $__templateResolver;    
    
    /**
     * Retrieve template name or template resolver
     *
     * @param  null|string $name
     * @return string|Resolver
     */
    public function resolver($name = null)
    {  
        if (null === $this->__templateResolver) {
            $this->setResolver(new TemplatePathStack());
        }

        if (null !== $name) {
            return $this->__templateResolver->resolve($name, $this);
        }

        return $this->__templateResolver;
    }

    /**
     * Return the template engine object
     *
     * Returns the object instance, as it is its own template engine
     *
     * @return MarkdownRenderer
     */
    public function getEngine()
    {
        return $this;
    }

    /**
     * Set script resolver
     * 
     * @param  Resolver $resolver
     * @return MarkdownRenderer
     * @throws Exception\InvalidArgumentException
     */
    public function setResolver(Resolver $resolver)
    {
        $this->__templateResolver = $resolver;
        return $this;
    }

    public function render($nameOrModel, $values = null)
    {
        var_dump($this->resolver($nameOrModel->getTemplate()));
        return "aaaa";
    }
}
