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

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeExtensionInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface;
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

        // Builds an array with service IDs as keys and tag class names as values
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
            $class = isset($tag[0]['class'])
                ? $tag[0]['class']
                : $this->getClassName($container, $serviceId, $tagName);

            // Flip, because we want tag classe names (= type identifiers) as keys
            if ($ext) {
                $services[$class][] = $serviceId;
            } else {
                $services[$class] = $serviceId;
            }
        }

        $container->getDefinition('sonatra_default_value.extension')->replaceArgument($argumentPosition, $services);
    }

    /**
     * Get the class name of default value type.
     *
     * @param ContainerBuilder $container The container service
     * @param string           $serviceId The service id of default value type
     * @param string           $tagName   The tag name
     *
     * @return string
     *
     * @throws InvalidConfigurationException When the service is not an instance of Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface
     */
    protected function getClassName(ContainerBuilder $container, $serviceId, $tagName)
    {
        $type = $container->get($serviceId);

        if ($type instanceof ObjectTypeExtensionInterface) {
            throw new InvalidConfigurationException(sprintf('The service id "%s" must have the "class" parameter in the "%s" tag.', $serviceId, $tagName));
        } elseif (!$type instanceof ObjectTypeInterface) {
            throw new InvalidConfigurationException(sprintf('The service id "%s" must an instance of "%s"', $serviceId, 'Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectTypeInterface'));
        }

        return $type->getClass();
    }
}
