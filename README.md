


## Usage

Create configuration in your application (eg. config/autoload/netorare.local.php)

```php
<?php
use Netorare\Mvc\Router\RoutePerTemplateIterator as Routes;

return [
    'router' => [
        'routes' => Routes::factory(__DIR__.'/../../module/Application/view/application/pages')
    ],
    'view_manager' => [
        'strategies' => [
            'NetorarePathinfoExtensionStrategy'
        ]
    ],
];
```

Netorare\Mvc\Router\RoutePerTemplateIterator::factory() generates routes
from set directory (factory() parameter)

