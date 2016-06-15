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
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
abstract class AbstractBaseExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectExtensionInterface
     */
    protected $extension;

    protected function setUp()
    {
        throw new \LogicException('The setUp() method must be overridden');
    }

    protected function tearDown()
    {
        $this->extension = null;
    }

    public function testHasType()
    {
        $this->assertTrue($this->extension->hasType('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User'));
        $this->assertFalse($this->extension->hasType('Foo'));
    }

    public function testHasTypeExtension()
    {
        $this->assertTrue($this->extension->hasTypeExtensions('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User'));
        $this->assertFalse($this->extension->hasTypeExtensions('Foo'));
    }

    public function testGetType()
    {
        $type = $this->extension->getType('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User');

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface', $type);
        $this->assertEquals('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User', $type->getClass());
    }

    /**
     * @expectedException \Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException
     */
    public function testGetUnexistingType()
    {
        $this->extension->getType('Foo');
    }

    public function testGetTypeExtension()
    {
        $exts = $this->extension->getTypeExtensions('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User');

        $this->assertTrue(is_array($exts));
        $this->assertCount(1, $exts);

        /* @var ObjectTypeExtensionInterface $ext */
        $ext = $exts[0];
        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface', $ext);
        $this->assertEquals('Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User', $ext->getExtendedType());
    }
}
