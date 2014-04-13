Getting Started With Sonatra DefaultValueBundle
===============================================

## Prerequisites

This version of the bundle requires Symfony 2.1+ and Twitter bootstrap.

## Installation

Installation is a quick, 2 step process:

1. Download Sonatra DefaultValueBundle using composer
2. Enable the bundle
3. Configure the bundle (optionnal)

### Step 1: Download Sonatra DefaultValueBundle using composer

Add Sonatra DefaultValueBundle in your composer.json:

``` js
{
    "require": {
        "sonatra/default-value-bundle": "~1.0"
    }
}
```

Or tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update sonatra/web-interface-bundle
```

Composer will install the bundle to your project's `vendor/sonatra` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sonatra\Bundle\DefaultValueBundle\SonatraDefaultValueBundle(),
    );
}
```

### Step 3: Configure the bundle (optionnal)

You can override the default configuration adding `sonatra_web_interface` tree in `app/config/config.yml`.
For see the reference of Sonatra DefaultValue Configuration, execute command:

``` bash
$ php app/console config:dump-reference SonatraDefaultValueBundle 
```

### Next Steps

Now that you have completed the basic installation and configuration of the
Sonatra DefaultValueBundle, you are ready to learn about usages of the bundle.
