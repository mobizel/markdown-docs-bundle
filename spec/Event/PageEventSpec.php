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

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Event;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Dto\PageOutput;
use Mobizel\Bundle\MarkdownDocsBundle\Event\PageEvent;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

class PageEventSpec extends ObjectBehavior
{
    function let(Request $request, ContextInterface $context): void
    {
        $this->beConstructedWith($request, new PageOutput('page', 'Page', ''), $context);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageEvent::class);
    }

    function it_returns_request(Request $request): void
    {
        $this->getRequest()->shouldReturn($request);
    }

    function it_returns_page(): void
    {
        $this->getPage()->shouldHaveType(PageOutput::class);
    }

    function it_returns_context(ContextInterface $context): void
    {
        $this->getContext()->shouldReturn($context);
    }
}
