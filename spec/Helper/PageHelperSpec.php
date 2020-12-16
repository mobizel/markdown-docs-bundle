<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\Helper\PageHelper;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;
use PhpSpec\ObjectBehavior;

class PageHelperSpec extends ObjectBehavior
{
    function let(TemplateHandlerInterface $templateHandler): void
    {
        $this->beConstructedWith($templateHandler);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageHelper::class);
    }

    function it_can_get_page_title(TemplateHandlerInterface $templateHandler): void
    {
        $templateHandler->getTemplateAbsolutePath('foo')->willReturn('tests/docs/foo.md');

        $this->getTitle('foo')->shouldReturn('Foo fighters');
    }

    function it_return_default_title_when_no_title_has_been_found(TemplateHandlerInterface $templateHandler): void
    {
        $templateHandler->getTemplateAbsolutePath('bar')->willReturn('tests/docs/bar.md');

        $this->getTitle('bar')->shouldReturn('Bar');
    }

    function it_return_default_title_when_file_is_empty(TemplateHandlerInterface $templateHandler): void
    {
        $templateHandler->getTemplateAbsolutePath('empty')->willReturn('tests/docs/empty.md');

        $this->getTitle('empty')->shouldReturn('Empty');
    }
}
