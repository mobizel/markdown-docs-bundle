<?php

/*
 * This file is part of markdown-docs-bundle.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterMarkdownExtraPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('twig.runtime.markdown')) {
            return;
        }

        $markdownRuntimeDefinition = $container->findDefinition('twig.runtime.markdown');
        $markdownRuntimeDefinition->setArgument(0, new Reference('mobizel.markdown_docs.markdown_extra'));
    }
}
