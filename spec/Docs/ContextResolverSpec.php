<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Docs;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextRegistryInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextResolver;
use PhpSpec\ObjectBehavior;

class ContextResolverSpec extends ObjectBehavior
{
    function let(ContextRegistryInterface $contextRegistry): void
    {
        $this->beConstructedWith($contextRegistry);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ContextResolver::class);
    }

    function it_does_not_returns_any_context_when_registry_is_empty(
        ContextRegistryInterface $contextRegistry
    ): void {
        $contextRegistry->getAll()->willReturn([]);

        $this->resolve('/docs')->shouldReturn(null);
    }

    function it_resolves_the_path_to_return_the_right_context(
        ContextRegistryInterface $contextRegistry,
        ContextInterface $currentVersionContext,
        ContextInterface $legacyVersionContext
    ): void {
        $contextRegistry->getAll()->willReturn([$currentVersionContext->getWrappedObject(), $legacyVersionContext->getWrappedObject()]);
        $currentVersionContext->getPath()->willReturn('/current');
        $currentVersionContext->getDocsDir()->willReturn('./docs/current');
        $legacyVersionContext->getPath()->willReturn('/1.2');
        $currentVersionContext->getDocsDir()->willReturn('./docs/1.2');

        $this->resolve('/current/setup/requirements')->shouldReturn($currentVersionContext);
        $this->resolve('/1.2/setup/requirements')->shouldReturn($legacyVersionContext);
    }
}
