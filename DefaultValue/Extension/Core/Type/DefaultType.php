<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\DefaultValue\Extension\Core\Type;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractType;

/**
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class DefaultType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param string $class
     */
    public function __construct($class = 'default')
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
