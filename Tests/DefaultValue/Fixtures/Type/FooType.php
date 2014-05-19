<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractType;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilderInterface;

class FooType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options)
    {
        // force the test to create instance with the default type
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo';
    }
}
