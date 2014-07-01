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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\PreloadedExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Extension\UserExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\UserType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class PreloadedExtensionTest extends AbstractBaseExtensionTest
{
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
}
