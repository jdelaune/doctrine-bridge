<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Doctrine\DependencyInjection\CompilerPass;

use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Types\UlidBinaryType;
use Symfony\Bridge\Doctrine\Types\UuidBinaryType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Uid\AbstractUid;

final class RegisterUidTypePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!class_exists(AbstractUid::class)) {
            return;
        }

        $typeDefinition = $container->getParameter('doctrine.dbal.connection_factory.types');

        if (!isset($typeDefinition['uuid'])) {
            $typeDefinition['uuid'] = ['class' => UuidType::class];
        }

        if (!isset($typeDefinition['ulid'])) {
            $typeDefinition['ulid'] = ['class' => UlidType::class];
        }

        if (!isset($typeDefinition['uuid_binary'])) {
            $typeDefinition['uuid_binary'] = ['class' => UuidBinaryType::class];
        }

        if (!isset($typeDefinition['ulid_binary'])) {
            $typeDefinition['ulid_binary'] = ['class' => UlidBinaryType::class];
        }

        $container->setParameter('doctrine.dbal.connection_factory.types', $typeDefinition);
    }
}
