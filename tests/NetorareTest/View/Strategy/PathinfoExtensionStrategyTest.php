<?php
namespace NetorareTest\View\Strategy;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\View\View;
use Zend\View\ViewEvent;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\AggregateResolver;
use Netorare\View\Strategy\PathinfoExtensionStrategy;
use Netorare\View\RendererPluginManager;

class PathinfoBasenameStrategyTest extends TestCase
{
    public function setUp()
    {
        $this->defaultRenderer = new PhpRenderer;
        $this->manager = new RendererPluginManager();
        $this->strategy = new PathinfoExtensionStrategy($this->manager, $this->defaultRenderer, new AggregateResolver);
        $this->event    = new ViewEvent();
    }

    public function testSelectRendererWithExtension()
    {
        $model = $this->getMock('Zend\View\Model\ModelInterface');
        $model->expects($this->at(0))
              ->method('getTemplate')
              ->will($this->returnValue('test.md'));

        $event = new ViewEvent;
        $event->setModel($model);

        $result = $this->strategy->selectRenderer($event);
        $this->assertInstanceOf('Netorare\View\Renderer\MarkdownRenderer', $result);
    }
}
