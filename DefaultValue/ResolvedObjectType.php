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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\InvalidArgumentException;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\Exception\UnexpectedTypeException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A wrapper for a object default value type and its extensions.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ResolvedObjectType implements ResolvedObjectTypeInterface
{
    /**
     * @var ObjectTypeInterface
     */
    protected $innerType;

    /**
     * @var ObjectTypeExtensionInterface[]
     */
    protected $typeExtensions;

    /**
     * @var ResolvedObjectTypeInterface
     */
    protected $parent;

    /**
     * @var OptionsResolver
     */
    protected $optionsResolver;

    /**
     * Constructor.
     *
     * @param ObjectTypeInterface            $innerType
     * @param ObjectTypeExtensionInterface[] $typeExtensions
     * @param ResolvedObjectTypeInterface    $parent
     *
     * @throws InvalidArgumentException When the object default value type classname does not exist
     * @throws UnexpectedTypeException  When unexpected type of argument
     */
    public function __construct(ObjectTypeInterface $innerType, array $typeExtensions = array(), ResolvedObjectTypeInterface $parent = null)
    {
        if ('default' !== $innerType->getClass() && !class_exists($innerType->getClass())) {
            throw new InvalidArgumentException(sprintf(
                'The "%s" object default value type class name ("%s") does not exists.',
                get_class($innerType),
                $innerType->getClass()
            ));
        }

        foreach ($typeExtensions as $extension) {
            if (!$extension instanceof ObjectTypeExtensionInterface) {
                throw new UnexpectedTypeException($extension, 'Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface');
            }
        }

        $this->innerType = $innerType;
        $this->typeExtensions = $typeExtensions;
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->innerType->getClass();
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getInnerType()
    {
        return $this->innerType;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeExtensions()
    {
        return $this->typeExtensions;
    }

    /**
     * {@inheritdoc}
     */
    public function createBuilder(ObjectFactoryInterface $factory, array $options = array())
    {
        $options = $this->getOptionsResolver()->resolve($options);
        $builder = new ObjectBuilder($factory, $options);
        $builder->setType($this);

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options)
    {
        $data = $this->innerType->newInstance($builder, $options);

        if (null === $data && null !== $this->parent) {
            $data = $this->parent->newInstance($builder, $options);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->buildObject($builder, $options);
        }

        $this->innerType->buildObject($builder, $options);

        foreach ($this->typeExtensions as $extension) {
            /* @var ObjectTypeExtensionInterface $extension */
            $extension->buildObject($builder, $options);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishObject(ObjectBuilderInterface $builder, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->finishObject($builder, $options);
        }

        $this->innerType->finishObject($builder, $options);

        foreach ($this->typeExtensions as $extension) {
            /* @var ObjectTypeExtensionInterface $extension */
            $extension->finishObject($builder, $options);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsResolver()
    {
        if (null === $this->optionsResolver) {
            if (null !== $this->parent) {
                $this->optionsResolver = clone $this->parent->getOptionsResolver();
            } else {
                $this->optionsResolver = new OptionsResolver();
            }

            $this->innerType->setDefaultOptions($this->optionsResolver);

            foreach ($this->typeExtensions as $extension) {
                /* @var ObjectTypeExtensionInterface $extension */
                $extension->setDefaultOptions($this->optionsResolver);
            }
        }

        return $this->optionsResolver;
    }
}
