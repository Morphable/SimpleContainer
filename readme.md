# Simple container component
A simple container component, easy to implement into any system

## Installing
```terminal
$ composer require morphable/simple-container
```

## Usage
```php
<?php

use \Morphable\SimpleContainer;

$container = new SimpleContainer();
$container->add('item', new MyClass());
$container->get('item');
$container->exists('item');
$container->update('item', 'something else');
$container->delete('item');

// if you don't know whether the item exists, every method except exists throws an exception

try {
    $container->get('item that does not exists');
} catch (\Morphable\SimpleContainer\Exception\InstanceNotFound $e) {
    // handle exception
}

try {
    $container->add('item that exists', '...');
} catch (\Morphable\SimpleContainer\Exception\InstanceAlreadyExists $e) {
    // handle exception
}

```

## Contributing
- Follow PSR-2 and the .editorconfig
- Start namespaces with \Morphable\SimpleContainer
- Make tests
