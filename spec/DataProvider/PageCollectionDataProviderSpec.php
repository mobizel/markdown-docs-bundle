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

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\DataProvider;

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageCollectionDataProvider;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

class PageCollectionDataProviderSpec extends ObjectBehavior
{
    function let(ReaderContextInterface $readerContext): void
    {
        $this->beConstructedWith($readerContext);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageCollectionDataProvider::class);
    }

    function it_returns_root_pages(
        ReaderContextInterface $readerContext,
        ContextInterface $context,
        Request $request
    ): void {
        $readerContext->getContext()->willReturn($context);
        $readerContext->getRequest()->willReturn($request);
        $context->getDocsDir($request)->willReturn(realpath(dirname(__FILE__).'/../../tests/docs'));

        $rootPages = $this->getRootPages();
        $rootPages->shouldHaveCount(7);
        $rootPages[0]->slug->shouldReturn('index');
        $rootPages[0]->title->shouldReturn('Documentation');
    }

    function it_returns_children_pages(
        ReaderContextInterface $readerContext,
        ContextInterface $context,
        Request $request
    ): void {
        $readerContext->getContext()->willReturn($context);
        $readerContext->getRequest()->willReturn($request);
        $context->getDocsDir($request)->willReturn(realpath(dirname(__FILE__).'/../../tests/docs'));

        $childrenPages = $this->getChildrenPages('products');
        $childrenPages->shouldHaveCount(2);
        $childrenPages[0]->slug->shouldReturn('products/books');
        $childrenPages[0]->title->shouldReturn('Book homepage');
        $childrenPages[1]->slug->shouldReturn('products/board-games');
        $childrenPages[1]->title->shouldReturn('Boardgames');
    }

    function it_returns_pages_map(
        ReaderContextInterface $readerContext,
        ContextInterface $context,
        Request $request
    ): void {
        $readerContext->getContext()->willReturn($context);
        $readerContext->getRequest()->willReturn($request);
        $context->getDocsDir($request)->willReturn(realpath(dirname(__FILE__).'/../../tests/docs'));

        $this->getPagesMap()->shouldReturn([
            'index' => 'Documentation',
            'bar' => 'Bar',
            'bar/man' => 'Man',
            'bar/el' => 'El',
            'chart' => 'Chart',
            'cookbook' => 'Cookbook',
            'cookbook/bdd' => 'BDD - Behaviour-driven development',
            'cookbook/bdd/phpspec' => 'Phpspec',
            'foo' => 'Foo fighters',
            'empty' => 'Empty',
            'products' => 'Products',
            'products/books' => 'Book homepage',
            'products/books/nicolas-beuglet' => 'Nicolas Beuglet',
            'products/books/stephen-king' => 'Stephen King Books',
            'products/board-games' => 'Boardgames',
            'products/board-games/puerto-rico' => 'Puerto-rico',
        ]);
    }

    function it_returns_pages_as_tree(
        ReaderContextInterface $readerContext,
        ContextInterface $context,
        Request $request
    ): void {
        $readerContext->getContext()->willReturn($context);
        $readerContext->getRequest()->willReturn($request);
        $context->getDocsDir($request)->willReturn(realpath(dirname(__FILE__).'/../../tests/docs'));

        $tree = $this->getPagesAsTree();

        $tree->shouldHaveCount(7);

        $tree['index']->shouldReturn([
            'slug' => 'index',
            'title' => 'Documentation',
            'metadata' => [],
            'children' => [],
        ]);

        $tree['products']->shouldReturn([
            'slug' => 'products',
            'title' => 'Products',
            'metadata' => [
                'icon' => ['data-feather' => 'box'],
            ],
            'children' => [
                'products/books' => [
                    'slug' => 'products/books',
                    'title' => 'Book homepage',
                    'metadata' => [],
                    'children' => [
                        'products/books/nicolas-beuglet' => [
                            'slug' => 'products/books/nicolas-beuglet',
                            'title' => 'Nicolas Beuglet',
                            'metadata' => [],
                            'children' => [],
                        ],
                        'products/books/stephen-king' => [
                            'slug' => 'products/books/stephen-king',
                            'title' => 'Stephen King Books',
                            'metadata' => [],
                            'children' => [],
                        ],
                    ],
                ],
                'products/board-games' => [
                    'slug' => 'products/board-games',
                    'title' => 'Boardgames',
                    'metadata' => [],
                    'children' => [
                        'products/board-games/puerto-rico' => [
                            'slug' => 'products/board-games/puerto-rico',
                            'title' => 'Puerto-rico',
                            'metadata' => [],
                            'children' => [],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
