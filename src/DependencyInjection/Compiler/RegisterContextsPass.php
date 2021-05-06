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

namespace Mobizel\Bundle\MarkdownDocsBundle\DependencyInjection\Compiler;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\Context;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterContextsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->registerCustomContexts($container);
    }

    private function registerCustomContexts(ContainerBuilder $container): void
    {
        /** @var array $contexts */
        $contexts = $container->getParameter('mobizel.markdown_docs.contexts');

        foreach ($contexts as $identifier => $data) {
            $definition = $container->register(sprintf('mobizel.markdown_docs.context.%s', $identifier), Context::class);
            $definition
                ->setArguments([
                    $identifier,
                    $data['path'],
                    $data['docs_dir'],
                    $data['requirements'],
                ])
                ->addTag('mobizel_markdown_docs.context');
        }
    }
}
