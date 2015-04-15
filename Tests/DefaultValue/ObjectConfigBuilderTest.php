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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectConfigBuilder;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectConfigBuilderInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectType;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foobar;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooCompletType;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectConfigBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectConfigBuilderInterface
     */
    protected $config;

    protected function setUp()
    {
        $options = array(
            'username' => 'foo',
            'password' => 'bar',
        );
        $rType = new ResolvedObjectType(new FooCompletType());

        $this->config = new ObjectConfigBuilder($options);
        $this->config->setType($rType);
    }

    protected function tearDown()
    {
        $this->config = null;
    }

    public function testGetObjectConfig()
    {
        $config = $this->config->getObjectConfig();

        $this->assertEquals($this->config, $config);
    }

    public function testGetObjectConfigWithConfigLocked()
    {
        $this->config->getObjectConfig();

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\BadMethodCallException');
        $this->config->getObjectConfig();
    }

    public function testGetType()
    {
        $type = $this->config->getType();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeInterface', $type);
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooCompletType', $type->getInnerType());
    }

    public function testSetType()
    {
        $type = $this->config->getType();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeInterface', $type);
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooCompletType', $type->getInnerType());

        $rType = new ResolvedObjectType(new FooType());
        $config = $this->config->setType($rType);
        $type2 = $this->config->getType();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectConfigBuilderInterface', $config);
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ResolvedObjectTypeInterface', $type2);
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\FooType', $type2->getInnerType());
    }

    public function testSetTypeWithConfigLocked()
    {
        $rType = new ResolvedObjectType(new FooType());

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\BadMethodCallException');
        $this->config->getObjectConfig();
        $this->config->setType($rType);
    }

    public function testGetOptions()
    {
        $opts = $this->config->getOptions();

        $this->assertTrue(is_array($opts));
    }

    public function testHasAndGetOption()
    {
        $this->assertTrue($this->config->hasOption('username'));
        $this->assertEquals('foo',$this->config->getOption('username', 'default value'));

        $this->assertTrue($this->config->hasOption('password'));
        $this->assertEquals('bar',$this->config->getOption('password', 'default value'));

        $this->assertFalse($this->config->hasOption('invalidProperty'));
        $this->assertEquals('default value',$this->config->getOption('invalidProperty', 'default value'));
    }

    public function testSetInvalidData()
    {
        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException');
        $this->config->setData(42);
    }

    public function testSetValidData()
    {
        $data = new User('root', 'p@ssword');
        $config = $this->config->setData($data);

        $this->assertEquals($this->config, $config);
        $this->assertEquals($data, $this->config->getData());
        $this->assertEquals(get_class($data), $this->config->getDataClass());
    }

    public function testSetValidDataWithConfigLocked()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);
        $this->config->getObjectConfig();

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\BadMethodCallException');
        $this->config->setData($data);
    }

    public function testGetProperties()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);
        $properties = $this->config->getProperties();

        $this->assertTrue(is_array($properties));
        $this->assertCount(9,$properties);
    }

    public function testGetProperty()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);

        $this->assertTrue($this->config->hasProperty('username'));
        $this->assertTrue($this->config->hasProperty('password'));
        $this->assertFalse($this->config->hasProperty('foobar'));

        $this->assertEquals('root', $this->config->getProperty('username'));
        $this->assertTrue($this->config->getProperty('enabled'));
        $this->assertTrue($this->config->getProperty('bar'));
        $this->assertFalse($this->config->getProperty('foo'));
    }

    public function testGetPropertyWithEmptyData()
    {
        $this->assertNull($this->config->getData());
        $this->assertNull($this->config->getDataClass());

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\BadMethodCallException');
        $this->config->getProperty('property');
    }

    public function testGetInvalidProperty()
    {
        $data = new User('root', 'p@ssword');
        $this->config->setData($data);

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException');
        $this->config->getProperty('invalidField');
    }

    public function testSetProperties()
    {
        $data = new Foobar();
        $data->setBar('hello world');
        $data->setCustomField('42');
        $this->config->setData($data);

        $this->assertEquals('hello world', $data->getBar());
        $this->assertEquals('42', $data->getCustomField());
        $this->assertEquals(false, $this->config->getProperty('privateProperty'));

        $config = $this->config->setProperties(array(
                'bar'             => 'value edited',
                'customField'     => '21',
                'privateProperty' => true,
        ));

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectConfigBuilderInterface', $config);
        $this->assertEquals('value edited', $data->getBar());
        $this->assertEquals('21', $data->getCustomField());
        $this->assertEquals(true, $this->config->getProperty('privateProperty'));
    }

    public function testSetPropertiesWithConfigLocked()
    {
        $data = new Foobar();
        $this->config->setData($data);
        $this->config->getObjectConfig();

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\BadMethodCallException');
        $this->config->setProperties(array(
            'bar' => 'value edited',
        ));
    }

    public function testSetPropertiesWithEmptyData()
    {
        $this->assertNull($this->config->getData());
        $this->assertNull($this->config->getDataClass());

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\BadMethodCallException');
        $this->config->setProperties(array(
            'property' => 'value',
        ));
    }

    public function testSetPropertiesWithInvalidClassProperty()
    {
        $data = new Foobar();
        $this->config->setData($data);

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException');
        $this->config->setProperties(array(
            'invalidProperty' => 'value',
        ));
    }

    public function testSetProperty()
    {
        $data = new Foobar();
        $data->setBar('hello world');
        $this->config->setData($data);

        $this->assertEquals('hello world', $data->getBar());

        $config = $this->config->setProperty('bar', 'value edited');

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectConfigBuilderInterface', $config);
        $this->assertEquals('value edited', $data->getBar());
    }

    public function testSetPropertyWithEmptyData()
    {
        $this->assertNull($this->config->getData());
        $this->assertNull($this->config->getDataClass());

        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\BadMethodCallException');
        $this->config->setProperty('property', 'value');
    }
}
