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
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\TestExpectedExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\TestExtension;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class AbstractExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $ext;

    protected function setUp()
    {

    }

    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException
     */
    public function testGetUnexistingType()
    {
        /* @var ObjectExtensionInterface $ext */
        $ext = $this->getMockForAbstractClass('Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractExtension');
        $ext->getType('unexisting_type');
    }

    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testInitLoadTypeException()
    {
        $ext = new TestExpectedExtension();
        $ext->getType('unexisting_type');
    }

    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException
     */
    public function testInitLoadTypeExtensionException()
    {
        $ext = new TestExpectedExtension();
        $ext->getTypeExtensions('unexisting_type');
    }

    public function testGetEmptyTypeExtension()
    {
        /* @var ObjectExtensionInterface $ext */
        $ext = $this->getMockForAbstractClass('Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractExtension');
        $typeExts = $ext->getTypeExtensions('unexisting_type_extension');

        $this->assertTrue(is_array($typeExts));
        $this->assertCount(0, $typeExts);
    }

    public function testGetType()
    {
        $ext = new TestExtension();
        $type = $ext->getType('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User');

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface', $type);
    }

    public function testHasType()
    {
        $ext = new TestExtension();

        $this->assertTrue($ext->hasType('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User'));
    }

    public function testGetTypeExtensions()
    {
        $ext = new TestExtension();
        $typeExts = $ext->getTypeExtensions('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User');

        $this->assertTrue(is_array($typeExts));
        $this->assertCount(1, $typeExts);
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface', $typeExts[0]);
    }

    public function testHasTypeExtensions()
    {
        $ext = new TestExtension();

        $this->assertTrue($ext->hasTypeExtensions('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User'));
    }
}
