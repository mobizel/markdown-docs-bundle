<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\DataProvider;

use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageCollectionDataProvider;
use PhpSpec\ObjectBehavior;

class PageCollectionDataProviderSpec extends ObjectBehavior
{
    function let(): void
    {
        $docsDir =  realpath(dirname(__FILE__).'/../../tests/docs');

        $this->beConstructedWith($docsDir);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageCollectionDataProvider::class);
    }

    function it_returns_pages_map(): void
    {
        $this->getPagesMap()->shouldReturn([
            'index' => 'Documentation',
            'bar' => 'Bar',
            'book' => 'Book homepage',
            'book/stephen-king' => 'Stephen King Books',
            'chart' => 'Chart',
            'cookbook' => 'Cookbook',
            'cookbook/bdd' => 'BDD - Behaviour-driven development',
            'cookbook/bdd/phpspec' => 'Phpspec',
            'empty' => 'Empty',
            'foo' => 'Foo fighters',
        ]);
    }
}
