<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Extension\DependencyInjection;

use Sonatra\Bundle\DefaultValueBundle\DependencyInjection\SonatraDefaultValueExtension;
use Sonatra\Bundle\DefaultValueBundle\SonatraDefaultValueBundle;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\AbstractBaseExtensionTest;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DependencyInjectionExtensionTest extends AbstractBaseExtensionTest
{
    protected function setUp()
    {
        $container = $this->getContainer('container2');

        $this->extension = $container->get('sonatra_default_value.extension');
    }

    protected function assertPreConditions()
    {
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectExtensionInterface', $this->extension);
    }

    protected function getContainer($service)
    {
        $container = new ContainerBuilder();
        $bundle = new SonatraDefaultValueBundle();
        $bundle->build($container); // Attach all default factories

        $extension = new SonatraDefaultValueExtension();
        $container->registerExtension($extension);
        $config = array();
        $extension->load(array($config), $container);

        $load = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../Fixtures/config'));
        $load->load($service.'.xml');

        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }

    public function testInvalidServiceAlias()
    {
        $container = $this->getContainer('container3');
        $extension = $container->get('sonatra_default_value.extension');
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectExtensionInterface', $extension);

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException');
        $extension->getType('user');
    }
}
