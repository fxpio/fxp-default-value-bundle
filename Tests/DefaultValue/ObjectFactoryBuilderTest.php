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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectExtensionInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilder;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeFactoryInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectFactoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectFactoryBuilderInterface
     */
    protected $builder;

    protected function setUp()
    {
        $this->builder = new ObjectFactoryBuilder();
    }

    protected function tearDown()
    {
        $this->builder = null;
    }

    public function testSetResolvedObjectTypeFactory()
    {
        /* @var ResolvedObjectTypeFactoryInterface $typeFactory */
        $typeFactory = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeFactoryInterface');

        $builder = $this->builder->setResolvedTypeFactory($typeFactory);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddExtension()
    {
        /* @var ObjectExtensionInterface $ext */
        $ext = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectExtensionInterface');

        $builder = $this->builder->addExtension($ext);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddExtensions()
    {
        $exts = array(
            $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectExtensionInterface'),
        );

        $builder = $this->builder->addExtensions($exts);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddType()
    {
        /* @var ObjectTypeInterface $type */
        $type = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface');

        $builder = $this->builder->addType($type);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypes()
    {
        $types = array(
            $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface'),
        );

        $builder = $this->builder->addTypes($types);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypeExtension()
    {
        /* @var ObjectTypeExtensionInterface $ext */
        $ext = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface');

        $builder = $this->builder->addTypeExtension($ext);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testAddTypeExtensions()
    {
        $exts = array(
            $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface'),
        );

        $builder = $this->builder->addTypeExtensions($exts);

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $builder);
    }

    public function testGetObjectFactory()
    {
        /* @var ObjectTypeInterface $type */
        $type = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface');
        $this->builder->addType($type);

        $of = $this->builder->getObjectFactory();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactory', $of);
    }
}
