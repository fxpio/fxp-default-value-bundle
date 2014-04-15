<?php

/*
 * This file is part of the Sonatra package.
*
* (c) François Pluchino <francois.pluchino@sonatra.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sonatra\Bundle\DefaultValueBundle\DefaultValue\Extension\Core\Type;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DefaultType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return 'default';
    }
}
