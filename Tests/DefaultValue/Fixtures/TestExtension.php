<?php

/**
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Extension\UserExtension;
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type\UserType;

/**
 * Test for extensions which provide types and type extensions.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TestExtension extends AbstractExtension
{
    protected function loadTypes()
    {
        return array(
            new UserType(),
        );
    }

    protected function loadTypeExtensions()
    {
        return array(
            new UserExtension(),
        );
    }
}
