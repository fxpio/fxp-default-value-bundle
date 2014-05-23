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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\PreloadedExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Extension\UserExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\UserType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class PreloadedExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PreloadedExtension
     */
    protected $extension;

    protected function setUp()
    {
        $types = array(
            'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User' => new UserType(),
        );
        $extensions = array(
            'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User' => array(new UserExtension()),
        );

        $this->extension = new PreloadedExtension($types, $extensions);
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

    public function testGetUnexistingType()
    {
        $this->setExpectedException('Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException');
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
