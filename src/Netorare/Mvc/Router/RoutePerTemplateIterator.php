<?php
namespace Netorare\Mvc\Router;

use IteratorIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

class RoutePerTemplateIterator extends IteratorIterator
{
    public static function factory($dir, $to_array = true)
    {
        $flag = FilesystemIterator::SKIP_DOTS|FilesystemIterator::KEY_AS_FILENAME;
        $self = new static(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, $flag)));
        return ($to_array) ? iterator_to_array($self) : $self;
    }

    public function key()
    {
        return pathinfo(parent::key(), PATHINFO_FILENAME);
    }

    public function current()
    {
        $pages_dir = 
            dirname(substr($p = $this->getPathname(), strlen(dirname(dirname(dirname($p)))) + 1));

        return [
            'type' => 'Literal',
            'options' => [
                'route' => '/'.$this->key(),
                'defaults' => [
                    'controller' => 'PhlySimplePage\Controller\Page',
                    'template' => $pages_dir.'/'.parent::key(),
                ]
            ]
        ];
    }
}

