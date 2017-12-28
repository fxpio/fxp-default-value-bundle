<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Bundle\DefaultValueBundle\Tests\DependencyInjection\Fixtures\Extension;

use Fxp\Component\DefaultValue\AbstractTypeExtension;
use Fxp\Component\DefaultValue\ObjectBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Default Value Extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
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
        $resolver->setDefaults([
            'test' => null,
        ]);

        $resolver->addAllowedTypes('test', ['null', 'string']);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'default';
    }
}
