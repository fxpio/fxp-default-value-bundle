<?php

/**
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilder;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilderInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectType;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooCompletType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectBuilderInterface
     */
    protected $builder;

    protected function setUp()
    {
        $options = array(
            'bar' => 'hello world',
        );
        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface');
        $type = new FooCompletType();
        $rType = new ResolvedObjectType($type);

        $this->builder = new ObjectBuilder($factory, $options);
        $this->builder->setType($rType);
    }

    protected function tearDown()
    {
        $this->builder = null;
    }

    public function testGetObjectFactory()
    {
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface', $this->builder->getObjectFactory());
    }

    public function testGetObjectWithoutData()
    {
        $instance = $this->builder->getObject();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $instance);
        $this->assertEquals('hello world', $instance->getBar());
    }

    public function testGetObjectWithoutDataWithEditionOnFinishMethod()
    {
        $options = array(
            'bar' => 'the answer to life, the universe, and everything',
        );
        /* @var ObjectFactoryInterface $factory */
        $factory = $this->getMock('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface');
        $type = new FooCompletType();
        $rType = new ResolvedObjectType($type);

        $this->builder = new ObjectBuilder($factory, $options);
        $this->builder->setType($rType);

        $instance = $this->builder->getObject();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $instance);
        $this->assertEquals('42', $instance->getBar());
    }

    public function testGetObjectWithData()
    {
        $data = new Foo();
        $data->setBar('new value');
        $this->builder->setData($data);
        $instance = $this->builder->getObject();

        $this->assertEquals($data, $instance);
        $this->assertEquals('new value', $instance->getBar());
    }

    public function testGetObjectWithDataWithEditionOnFinishMethod()
    {
        $data = new Foo();
        $data->setBar('the answer to life, the universe, and everything');
        $this->builder->setData($data);
        $instance = $this->builder->getObject();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo', $instance);
        $this->assertEquals('42', $instance->getBar());
    }
}
