<?php

/*
 * This file is part of the Mobizel package.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle;

use Mobizel\Bundle\MarkdownDocsBundle\DependencyInjection\Compiler\RegisterContextsPass;
use Mobizel\Bundle\MarkdownDocsBundle\DependencyInjection\Compiler\RegisterMarkdownExtraPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class MobizelMarkdownDocsBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterMarkdownExtraPass());
        $container->addCompilerPass(new RegisterContextsPass());
    }
}
