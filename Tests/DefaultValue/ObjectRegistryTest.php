<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectRegistry;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectRegistryInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeFactory;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\TestExtension;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectRegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectRegistryInterface
     */
    protected $registry;

    protected function setUp()
    {
        $this->registry = new ObjectRegistry(array(
            new TestExtension(),
        ), new ResolvedObjectTypeFactory());
    }

    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testExtensionUnexpectedTypeException()
    {
        new ObjectRegistry(array(
            42,
        ), new ResolvedObjectTypeFactory());
    }

    public function testHasTypeObject()
    {
        $classname = 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User';
        $classname2 = 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\UnexistingType';

        $this->assertTrue($this->registry->hasType($classname));
        $this->assertTrue($this->registry->hasType($classname));// uses cache in class
        $this->assertFalse($this->registry->hasType($classname2));
    }

    public function testGetTypeObject()
    {
        $classname = 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
    }

    public function testGetDefaultTypeObject()
    {
        $classname = 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo';
        $resolvedType = $this->registry->getType($classname);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeInterface', $resolvedType);
        $this->assertEquals($classname, $resolvedType->getClass());
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Extension\Core\Type\DefaultType', $resolvedType->getInnerType());
    }

    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testGetTypeObjectUnexpectedTypeException()
    {
        $this->registry->getType(42);
    }

    public function testGetExtensions()
    {
        $exts = $this->registry->getExtensions();
        $this->assertTrue(is_array($exts));
        $this->assertCount(1, $exts);
    }
}
