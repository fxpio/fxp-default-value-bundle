<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Adds all services with the tags "sonatra_default_value.type" as arguments of
 * the "sonatra_default_value.extension" service.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DefaultValuePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sonatra_default_value.extension')) {
            return;
        }

        // Builds an array with service IDs as keys and tag aliases as values
        $types = array();

        foreach ($container->findTaggedServiceIds('sonatra_default_value.type') as $serviceId => $tag) {
            $alias = isset($tag[0]['alias'])
                ? $tag[0]['alias']
                : null;

            if (null === $alias) {
                throw new InvalidConfigurationException(sprintf('The service id "%s" must have the "alias" parameter in the "sonatra_default_value.type" tag.', $serviceId));
            }

            // Flip, because we want tag aliases (= type identifiers) as keys
            $types[$alias] = $serviceId;
        }

        $container->getDefinition('sonatra_default_value.extension')->replaceArgument(1, $types);

        $typeExtensions = array();

        foreach ($container->findTaggedServiceIds('sonatra_default_value.type_extension') as $serviceId => $tag) {
            $alias = isset($tag[0]['alias'])
                ? $tag[0]['alias']
                : null;

            if (null === $alias) {
                throw new InvalidConfigurationException(sprintf('The service id "%s" must have the "alias" parameter in the "sonatra_default_value.type_extension" tag.', $serviceId));
            }

            $typeExtensions[$alias][] = $serviceId;
        }

        $container->getDefinition('sonatra_default_value.extension')->replaceArgument(2, $typeExtensions);
    }
}
