<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Type;

use Sonatra\Bundle\DefaultValueBundle\DefaultValue\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonatra\Bundle\DefaultValueBundle\DefaultValue\ObjectBuilderInterface;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function newInstance(ObjectBuilderInterface $builder, array $options)
    {
        $class = $this->getClass();

        return new $class($options['username'], $options['password']);
    }

    /**
     * {@inheritdoc}
     */
    public function buildObject(ObjectBuilderInterface $builder, array $options)
    {
        $builder->setProperty('enabled', false);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'username' => 'test',
                'password' => 'password',
            ));
    }

    public function getClass()
    {
        return 'Sonatra\Bundle\DefaultValueBundle\Tests\DefaultValue\Fixtures\Object\User';
    }
}
