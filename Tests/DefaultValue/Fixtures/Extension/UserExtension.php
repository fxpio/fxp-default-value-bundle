<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Extension;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractTypeExtension;

class UserExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User';
    }
}
