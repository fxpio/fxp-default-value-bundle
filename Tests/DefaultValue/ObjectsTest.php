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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\Objects;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectsTest extends \PHPUnit_Framework_TestCase
{
    public function testObjectFactoryBuilderCreator()
    {
        $of = Objects::createObjectFactoryBuilder();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryBuilderInterface', $of);
    }

    public function testObjectFactoryCreator()
    {
        $of = Objects::createObjectFactory();

        $this->assertInstanceOf('Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectFactoryInterface', $of);
    }
}
