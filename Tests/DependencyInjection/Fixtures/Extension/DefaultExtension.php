<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\Fixtures\Extension;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractTypeExtension;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Block Block Extension.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class BlockExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'test' => null,
        ));

        $resolver->addAllowedTypes(array(
            'test' => array('null', 'string'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'default';
    }
}
