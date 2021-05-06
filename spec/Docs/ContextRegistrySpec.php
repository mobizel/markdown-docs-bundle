<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Docs;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextRegistry;
use PhpSpec\ObjectBehavior;

class ContextRegistrySpec extends ObjectBehavior
{
    function let(ContextInterface $firstContext, ContextInterface $secondContext): void
    {
        $firstContext->getName()->willReturn('first');
        $secondContext->getName()->willReturn('second');
        $this->beConstructedWith([$firstContext, $secondContext]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ContextRegistry::class);
    }

    function it_adds_contexts(ContextInterface $context): void
    {
        $context->getName()->willReturn('third');

        $this->add($context);

        $this->getAll()->shouldContain($context);
        $this->getAll()->shouldHaveCount(3);
    }

    function it_returns_all_contexts(ContextInterface $firstContext, ContextInterface $secondContext): void
    {
        $this->getAll()->shouldContain($firstContext);
        $this->getAll()->shouldContain($secondContext);
    }
}
