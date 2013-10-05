<?php
namespace Netorare\View\Renderer;

use Michelf\MarkdownExtra;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface as Resolver;
use Zend\View\Resolver\TemplatePathStack;

class MarkdownRenderer implements RendererInterface
{
    /**
     * @var MarkdownExtra
     */
    protected $markdown;

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

    public function setEngine($markdown)
    {
        $this->markdown = $markdown;
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
        if (!$this->markdown) {
            $this->markdown = new MarkdownExtra;
        }

        return $this->markdown;
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
        $file = $this->resolver($nameOrModel->getTemplate());
        return $this->getEngine()->transform(file_get_contents($file));
    }
}
