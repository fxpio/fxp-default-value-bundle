Getting Started
===============

## Prerequisites

This version of the bundle requires Symfony 2.4+.

## Installation

Installation is a quick, 2 step process:

1. Download the bundle using composer
2. Enable the bundle

### Step 1: Download the bundle using composer

Add Sonatra DefaultValueBundle in your composer.json:

```js
{
    "require": {
        "sonatra/default-value-bundle": "~1.0"
    }
}
```

Or tell composer to download the bundle by running the command:

```bash
$ php composer.phar update sonatra/web-interface-bundle
```

Composer will install the bundle to your project's `vendor/sonatra` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sonatra\Bundle\DefaultValueBundle\SonatraDefaultValueBundle(),
    );
}
```

### Next Steps

Now that you have completed the basic installation and configuration of the
Sonatra DefaultValueBundle, you are ready to learn about usages of the bundle.
