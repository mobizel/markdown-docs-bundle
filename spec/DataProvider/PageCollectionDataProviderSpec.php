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

    function it_returns_root_pages(): void
    {
        $rootPages = $this->getRootPages();
        $rootPages->shouldHaveCount(6);
        $rootPages[0]->slug->shouldReturn('bar');
        $rootPages[0]->title->shouldReturn('Bar');
    }

    function it_returns_children_pages(): void
    {
        $childrenPages = $this->getChildrenPages('products');
        $childrenPages->shouldHaveCount(1);
        $childrenPages[0]->slug->shouldReturn('products/books');
        $childrenPages[0]->title->shouldReturn('Book homepage');
    }

    function it_returns_pages_map(): void
    {
        $this->getPagesMap()->shouldReturn([
            'index' => 'Documentation',
            'bar' => 'Bar',
            'chart' => 'Chart',
            'cookbook' => 'Cookbook',
            'cookbook/bdd' => 'BDD - Behaviour-driven development',
            'cookbook/bdd/phpspec' => 'Phpspec',
            'empty' => 'Empty',
            'foo' => 'Foo fighters',
            'products' => 'Products',
            'products/books' => 'Book homepage',
            'products/books/stephen-king' => 'Stephen King Books',
        ]);
    }
}
