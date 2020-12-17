<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Page;

use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;
use PhpSpec\ObjectBehavior;

class PageInfoSpec extends ObjectBehavior
{
    function it_can_get_page_title(): void
    {
        $this->beConstructedWith('tests/docs/foo.md', '', '');
        $this->getTitle()->shouldReturn('Foo fighters');
    }

    function it_return_default_title_when_no_title_has_been_found(TemplateHandlerInterface $templateHandler): void
    {
        $this->beConstructedWith('tests/docs/bar.md', '', '');

        $this->getTitle()->shouldReturn('Bar');
    }

    function it_return_default_title_when_file_is_empty(TemplateHandlerInterface $templateHandler): void
    {
        $this->beConstructedWith('tests/docs/empty.md', '', '');

        $this->getTitle()->shouldReturn('Empty');
    }

    function it_can_get_content(): void
    {
        $this->beConstructedWith('tests/docs/foo.md', '', '');

        $this->getContent()->shouldContain('# Foo fighters');
    }

    function it_can_get_content_without_title(): void
    {
        $this->beConstructedWith('tests/docs/foo.md', '', '');

        $this->getContentWithoutTitle()->shouldNotContain('# Foo fighters');
    }
}
