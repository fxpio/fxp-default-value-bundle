<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DependencyInjection\Fixtures\Extension;

use Sonatra\Component\DefaultValue\AbstractTypeExtension;
use Sonatra\Component\DefaultValue\ObjectBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Default Value Extension.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DefaultExtension extends AbstractTypeExtension
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'test' => null,
        ));

        $resolver->addAllowedTypes('test', array('null', 'string'));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'default';
    }
}
