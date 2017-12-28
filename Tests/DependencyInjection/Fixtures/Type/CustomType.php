<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Bundle\DefaultValueBundle\Tests\DependencyInjection\Fixtures\Type;

use Fxp\Component\DefaultValue\AbstractSimpleType;

/**
 * Invalid default value type.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class CustomType extends AbstractSimpleType
{
    /**
     * @var bool
     */
    protected $foo;

    /**
     * Constructor.
     *
     * @param string $class The class name
     * @param bool   $foo   The foo
     */
    public function __construct($class, $foo)
    {
        parent::__construct($class);

        $this->foo = $foo;
    }
}
