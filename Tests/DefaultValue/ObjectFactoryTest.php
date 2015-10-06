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
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactory;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectRegistry;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\PreloadedExtension;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeFactory;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooCompletType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectFactoryInterface
     */
    protected $factory;

    protected function setUp()
    {
        $exts = array(
            new PreloadedExtension(array(
                'default' => new DefaultType(),
                'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo' => new FooCompletType(),
            ), array()),
        );
        $registry = new ObjectRegistry($exts, new ResolvedObjectTypeFactory());

        $this->factory = new ObjectFactory($registry, new ResolvedObjectTypeFactory());
    }

    protected function tearDown()
    {
        $this->factory = null;
    }

    public function testCreateBuilderWithObjectTypeInstance()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $builder = $this->factory->createBuilder($type, null, array('bar' => 'hello world'));

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectConfigBuilderInterface', $builder);
        $this->assertNull($builder->getData());

        $instance = $builder->getObject();
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceWithSpecialValueOfBarField()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $builder = $this->factory->createBuilder($type, null, array('bar' => 'the answer to life, the universe, and everything'));
        $instance = $builder->getObject();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndData()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $builder = $this->factory->createBuilder($type, $data, array('bar' => 'hello world'));
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndDataWithValueInField()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $data->setBar('has value');
        $builder = $this->factory->createBuilder($type, $data, array('bar' => 'hello world'));
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('has value', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceAndDataWithValueInFieldWithSpecialValueOfBarField()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());
        $data = new Foo();
        $data->setBar('the answer to life, the universe, and everything');
        $builder = $this->factory->createBuilder($type, $data, array('bar' => 'hello world'));
        $instance = $builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    public function testCreateBuilderWithObjectTypeInstanceWithoutOptions()
    {
        $type = new FooCompletType();
        $type->configureOptions(new OptionsResolver());

        $this->setExpectedException('Symfony\Component\OptionsResolver\Exception\InvalidOptionsException');
        $this->factory->createBuilder($type);
    }

    public function testCreateBuilderWithString()
    {
        $builder = $this->factory->createBuilder('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', null, array('bar' => 'hello world'));

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectConfigBuilderInterface', $builder);
        $this->assertNull($builder->getData());

        $instance = $builder->getObject();
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateBuilderWithTypeIsNotAResolvedObjectTypeInstance()
    {
        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException');
        $this->factory->createBuilder(42);
    }

    public function testCreateObject()
    {
        $instance = $this->factory->create('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', null, array('bar' => 'hello world'));

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testCreateObjectWithData()
    {
        $data = new Foo();
        $data->setBar('has value');
        $instance = $this->factory->create('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $data, array('bar' => 'hello world'));

        $this->assertEquals($data, $instance);
        $this->assertEquals('has value', $instance->getBar());
    }

    public function testInjectDefaultValueInObject()
    {
        $data = new Foo();
        $instance = $this->factory->inject($data, array('bar' => 'hello world'));

        $this->assertEquals($data, $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testInjectDefaultValueInNonObject()
    {
        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException');
        $this->factory->inject(42);
    }
}
