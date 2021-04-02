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
        $rootPages->shouldHaveCount(7);
        $rootPages[0]->slug->shouldReturn('index');
        $rootPages[0]->title->shouldReturn('Documentation');
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

    function it_returns_pases_as_tree(): void
    {
        $tree = $this->getPagesAsTree();

        $tree->shouldHaveCount(7);

        $tree['index']->shouldReturn([
            'title' => 'Documentation',
            'children' => [],
        ]);

        $tree['products']->shouldReturn([
            'title' => 'Products',
            'children' => [
                'products/books' => [
                    'title' => 'Book homepage',
                    'children' => [
                        'products/books/stephen-king' => [
                            'title' => 'Stephen King Books',
                            'children' => [],
                        ]
                    ],
                ],
            ],
        ]);
    }
}
