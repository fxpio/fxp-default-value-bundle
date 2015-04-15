<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sonatra\Bundle\DefaultValueBundle\DependencyInjection\Compiler\DefaultValuePass;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class SonatraDefaultValueBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DefaultValuePass(), PassConfig::TYPE_OPTIMIZE);
    }
}
