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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\Extension\Core\Type\DefaultType;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectType;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Extension\UserExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooType;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\UserType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ResolvedObjectTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException
     */
    public function testClassUnexist()
    {
        $type = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface');
        $type->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\UnexistClass'));

        /* @var ObjectTypeInterface $type */
        new ResolvedObjectType($type);
    }

    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testWrongExtensions()
    {
        $type = new UserType();

        new ResolvedObjectType($type, array('wrong_extension'));
    }

    public function testBasicOperations()
    {
        $parentType = new DefaultType();
        $type = new UserType();
        $rType = new ResolvedObjectType($type, array(new UserExtension()), new ResolvedObjectType($parentType));

        $this->assertEquals($type->getClass(), $rType->getClass());
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeInterface', $rType->getParent());
        $this->assertEquals($type, $rType->getInnerType());

        $exts = $rType->getTypeExtensions();
        $this->assertTrue(is_array($exts));
        $this->assertCount(1, $exts);

        $options = $rType->getOptionsResolver();
        $this->assertInstanceOf('Symfony\Component\OptionsResolver\OptionsResolver', $options);
    }

    public function testInstanceBuilder()
    {
        $rType = $this->getResolvedType();
        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface');
        $builder = $rType->createBuilder($factory, array());

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilderInterface', $builder);
        $this->assertEquals($rType, $builder->getType());

        $instance = $rType->newInstance($builder, $builder->getOptions());

        $rType->buildObject($builder, $builder->getOptions());
        $rType->finishObject($builder, $builder->getOptions());

        $this->assertInstanceOf($rType->getClass(), $instance);
        $this->assertEquals('test', $instance->getUsername());
        $this->assertEquals('password', $instance->getPassword());
    }

    /**
     * @group fxp
     */
    public function testInstanceBuilderWithDefaultType()
    {
        $type = new FooType();
        $parentType = new DefaultType($type->getClass());
        $rType = new ResolvedObjectType($type, array(), new ResolvedObjectType($parentType));

        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface');
        $builder = $rType->createBuilder($factory, array());

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilderInterface', $builder);
        $this->assertEquals($rType, $builder->getType());

        $instance = $rType->newInstance($builder, $builder->getOptions());

        $rType->buildObject($builder, $builder->getOptions());
        $rType->finishObject($builder, $builder->getOptions());

        $this->assertInstanceOf($rType->getClass(), $instance);
    }

    /**
     * Gets resolved type.
     *
     * @return ResolvedObjectType
     */
    private function getResolvedType()
    {
        $type = new UserType();
        $parentType = new DefaultType($type->getClass());

        return new ResolvedObjectType($type, array(new UserExtension()), new ResolvedObjectType($parentType));
    }
}
