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

namespace Mobizel\Bundle\MarkdownDocsBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Mobizel\Bundle\MarkdownDocsBundle\DependencyInjection\Compiler\RegisterMarkdownExtraPass;
use Mobizel\Bundle\MarkdownDocsBundle\Markdown\MarkdownExtra;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Twig\Extra\Markdown\MarkdownRuntime;

final class RegisterMarkdownExtraPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_registers_client_manager_if_not_oauth_is_configured(): void
    {
        $this->registerService('twig.runtime.markdown', MarkdownRuntime::class);
        $this->registerService('mobizel.markdown_docs.markdown_extra', MarkdownExtra::class);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'twig.runtime.markdown',
            0,
            new Reference('mobizel.markdown_docs.markdown_extra')
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterMarkdownExtraPass());
    }
}
