<?php

/**
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DependencyInjection;

use Sonatra\Bundle\DefaultValueBundle\DependencyInjection\SonatraDefaultValueExtension;
use Sonatra\Bundle\DefaultValueBundle\SonatraDefaultValueBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Bundle Extension Tests.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class SonatraDefaultValueExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testCompileContainerWithExtension()
    {
        $container = $this->getContainer();
        $this->assertTrue($container->hasDefinition('sonatra_default_value.extension'));
        $this->assertTrue($container->hasDefinition('sonatra_default_value.registry'));
        $this->assertTrue($container->hasDefinition('sonatra_default_value.resolved_type_factory'));
    }

    public function testCompileContainerWithoutExtension()
    {
        $container = $this->getContainer(true);
        $this->assertFalse($container->hasDefinition('sonatra_default_value.extension'));
        $this->assertFalse($container->hasDefinition('sonatra_default_value.registry'));
        $this->assertFalse($container->hasDefinition('sonatra_default_value.resolved_type_factory'));
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadExtensionWithoutAlias()
    {
        $this->getContainer(false, 'container_exception');
    }

    public function testLoadDefaultExtensionWithAlias()
    {
        $container = $this->getContainer(false, 'container_extension');
        $this->assertTrue($container->hasDefinition('test.sonatra_default_value.type.default'));
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadDefaultExtensionWithoutAlias()
    {
        $this->getContainer(false, 'container_extension_exception');
    }

    /**
     * Gets the container.
     *
     * @param bool   $empty    Compile container without extension
     * @param string $services The services definition
     *
     * @return ContainerBuilder
     */
    protected function getContainer($empty = false, $services = null)
    {
        $container = new ContainerBuilder();
        $bundle = new SonatraDefaultValueBundle();
        $bundle->build($container); // Attach all default factories

        if (!$empty) {
            $extension = new SonatraDefaultValueExtension();
            $container->registerExtension($extension);
            $config = array();
            $extension->load(array($config), $container);
        }

        if (null !== $services) {
            $load = new XmlFileLoader($container, new FileLocator(__DIR__.'/Fixtures/Resources/config'));
            $load->load($services.'.xml');
        }

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }
}
