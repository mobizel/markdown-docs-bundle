<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Template;

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateResolver;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

class TemplateResolverSpec extends ObjectBehavior
{
    function let(ReaderContextInterface $readerContext): void
    {
        $this->beConstructedWith($readerContext);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(TemplateResolver::class);
    }

    function it_resolves_the_context_to_use(
        Request $request,
        ReaderContextInterface $readerContext,
        ContextInterface $context
    ): void {
        $request->get('slug')->willReturn('cookbook/bdd');
        $readerContext->getContext()->willReturn($context);
        $context->getDocsDir($request)->willReturn(dirname(__FILE__).'/../../tests/docs');

        $this->resolve($request)->shouldNotBeNull();
    }

    function it_returns_null_when_template_was_not_found(
        Request $request,
        ReaderContextInterface $readerContext,
        ContextInterface $context
    ): void {
        $request->get('slug')->willReturn('not-found');
        $readerContext->getContext()->willReturn($context);
        $context->getDocsDir($request)->willReturn(dirname(__FILE__).'/../../tests/docs');

        $this->resolve($request)->shouldBeNull();
    }
}
