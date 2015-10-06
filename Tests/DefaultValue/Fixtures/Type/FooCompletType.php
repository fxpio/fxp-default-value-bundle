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
use Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FooCompletType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options)
    {
        /* @var Foo $data */
        $data = $builder->getData();

        if (null === $data->getBar()) {
            $data->setBar($options['bar']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options)
    {
        /* @var Foo $data */
        $data = $builder->getData();

        if ('the answer to life, the universe, and everything' === $data->getBar()) {
            $data->setBar('42');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'bar' => null,
        ));

        $resolver->addAllowedTypes('bar', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\Foo';
    }
}
