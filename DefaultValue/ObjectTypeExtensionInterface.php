<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\DefaultValue;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface ObjectTypeExtensionInterface
{
    /**
     * Builds the object default value.
     *
     * This method is called for each type in the hierarchy starting object the
     * top most type. Type extensions can further modify the object.
     *
     * @param ObjectBuilderInterface $builder The object builder
     * @param array                  $options The options
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options);

    /**
     * Finishes the object.
     *
     * This method is called for each type in the hierarchy ending object the
     * top most type. Type extensions can further modify the object.
     *
     * @param ObjectBuilderInterface $builder The object builder
     * @param array                  $options The options
    */
    public function finishObject(ObjectBuilderInterface $builder, array $options);

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver);

    /**
     * Returns the class name of the type being extended.
     *
     * @return string The class name of the type being extended
     */
    public function getExtendedType();
}