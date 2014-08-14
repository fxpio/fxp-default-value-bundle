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
        $this->findTags($container, 'sonatra_default_value.type', 0);
        $this->findTags($container, 'sonatra_default_value.type_extension', 1, true);
    }

    /**
     * Find service tags.
     *
     * @param ContainerBuilder $container
     * @param string           $tagName
     * @param int              $argumentPosition
     * @param bool             $ext
     *
     * @throws InvalidConfigurationException
     */
    protected function findTags(ContainerBuilder $container, $tagName, $argumentPosition, $ext = false)
    {
        $services = array();

        foreach ($container->findTaggedServiceIds($tagName) as $serviceId => $tag) {
            $alias = isset($tag[0]['alias'])
                ? $tag[0]['alias']
                : null;

            if (null === $alias) {
                throw new InvalidConfigurationException(sprintf('The service id "%s" must have the "alias" parameter in the "%s" tag.', $serviceId, $tagName));
            }

            // Flip, because we want tag aliases (= type identifiers) as keys
            if ($ext) {
                $services[$alias][] = $serviceId;
            } else {
                $services[$alias] = $serviceId;
            }
        }

        $container->getDefinition('sonatra_default_value.extension')->replaceArgument($argumentPosition, $services);
    }
}
