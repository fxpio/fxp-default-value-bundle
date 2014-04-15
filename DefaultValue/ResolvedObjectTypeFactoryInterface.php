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

/**
 * Creates ResolvedObjectTypeInterface instances.
 *
 * This interface allows you to use your custom ResolvedObjectTypeInterface
 * implementation, within which you can customize the concrete ObjectBuilderInterface
 * implementations.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface ResolvedObjectTypeFactoryInterface
{
    /**
     * Resolves a object default value type.
     *
     * @param ObjectTypeInterface         $type
     * @param array                       $typeExtensions
     * @param ResolvedObjectTypeInterface $parent
     *
     * @return ResolvedObjectTypeInterface
     *
     * @throws Exception\UnexpectedTypeException If the types parent {@link ObjectTypeInterface::getParent()} is not a string
     * @throws Exception\Exception               If the types parent can not be retrieved object default value any extension
     */
    public function createResolvedType(ObjectTypeInterface $type, array $typeExtensions, ResolvedObjectTypeInterface $parent = null);
}
