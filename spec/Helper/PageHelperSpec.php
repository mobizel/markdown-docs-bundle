<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\Helper\PageHelper;
use PhpSpec\ObjectBehavior;

class PageHelperSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith([
            'first-page' => 'First page',
            'foo' => 'Foo fighters',
            'last-page' => 'Last page',
        ]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageHelper::class);
    }

    function it_can_get_page_title(): void
    {
        $this->getTitle('foo')->shouldReturn('Foo fighters');
    }

    function it_can_get_previous_page(): void
    {
        $this->getPreviousPage('foo')->shouldReturn('first-page');
        $this->getPreviousPage('first-page')->shouldReturn(null);
    }

    function it_can_get_next_page(): void
    {
        $this->getNextPage('foo')->shouldReturn('last-page');
        $this->getNextPage('last-page')->shouldReturn(null);
    }
}
