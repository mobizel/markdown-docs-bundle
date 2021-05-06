<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Page;

use PhpSpec\ObjectBehavior;

class PageInfoSpec extends ObjectBehavior
{
    function it_can_get_page_title(): void
    {
        $this->beConstructedWith('tests/docs/foo.md', '', '');
        $this->getTitle()->shouldReturn('Foo fighters');
    }

    function it_return_default_title_when_no_title_has_been_found(): void
    {
        $this->beConstructedWith('tests/docs/bar.md', '', '');

        $this->getTitle()->shouldReturn('Bar');
    }

    function it_return_default_title_when_file_is_empty(): void
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

    function it_can_get_table_of_contents(): void
    {
        $this->beConstructedWith('tests/docs/index.md', '', '');

        $expectedTableOfContents = <<<EOM
* [Chapter 1](#chapter-1)
    * [1.1 - Requirements](#1.1)
    * [1.2 - Setup](#1.2)
* [Chapter 2](#chapter-2)
    * [2.1](#2.1)
    * [2.2](#2.2)
EOM;

        $this->getTableOfContents()->shouldReturn($expectedTableOfContents);
    }
}
