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

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Page;

use Mobizel\Bundle\MarkdownDocsBundle\Page\PageSorter;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Finder\SplFileInfo;

class PageSorterSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageSorter::class);
    }

    function it_makes_homepage_always_at_first_position(SplFileInfo $a, SplFileInfo $b): void
    {
        $closure = $this::sort();

        $a->getRelativePathname()->willReturn('foo.md');
        $b->getRelativePathname()->willReturn('index.md');

        $closure->call($this, $a, $b)->shouldReturn(1);
        $closure->call($this, $b, $a)->shouldReturn(-1);
    }

    function it_sorts_by_page_title(SplFileInfo $a, SplFileInfo $b): void
    {
        $closure = $this::sort();

        $docsDir = __DIR__.'/../../tests/docs';

        $a->getRelativePath()->willReturn($docsDir);
        $a->getRelativePathname()->willReturn('bar.md');
        $a->getPathname()->willReturn($docsDir.'/bar.md');

        $b->getRelativePath()->willReturn($docsDir);
        $b->getRelativePathname()->willReturn('foo.md');
        $b->getPathname()->willReturn($docsDir.'/foo.md');

        $closure->call($this, $a, $b)->shouldReturn(-4);
        $closure->call($this, $b, $a)->shouldReturn(4);
    }

    function it_allows_to_customize_one_page_position(SplFileInfo $a, SplFileInfo $b): void
    {
        $closure = $this::sort(['foo.md']);

        $docsDir = __DIR__.'/../../tests/docs';

        $a->getRelativePath()->willReturn($docsDir);
        $a->getRelativePathname()->willReturn('bar.md');
        $a->getPathname()->willReturn($docsDir.'/bar.md');

        $b->getRelativePath()->willReturn($docsDir);
        $b->getRelativePathname()->willReturn('foo.md');
        $b->getPathname()->willReturn($docsDir.'/foo.md');

        $closure->call($this, $a, $b)->shouldReturn(1);
        $closure->call($this, $b, $a)->shouldReturn(-1);
    }

    function it_allows_to_customize_all_page_positions(SplFileInfo $a, SplFileInfo $b): void
    {
        $closure = $this::sort([
            'foo.md',
            'bar.md',
        ]);

        $docsDir = __DIR__.'/../../tests/docs';

        $a->getRelativePath()->willReturn($docsDir);
        $a->getRelativePathname()->willReturn('bar.md');
        $a->getPathname()->willReturn($docsDir.'/bar.md');

        $b->getRelativePath()->willReturn($docsDir);
        $b->getRelativePathname()->willReturn('foo.md');
        $b->getPathname()->willReturn($docsDir.'/foo.md');

        $closure->call($this, $a, $b)->shouldReturn(1);
        $closure->call($this, $b, $a)->shouldReturn(-1);
    }

    function it_allows_to_customize_one_page_position_when_pages_are_on_index_files(SplFileInfo $a, SplFileInfo $b): void
    {
        $closure = $this::sort(['books/index.md']);

        $docsDir = __DIR__.'/../../tests/docs';

        $a->getRelativePath()->willReturn($docsDir);
        $a->getRelativePathname()->willReturn('board-games/index.md');
        $a->getPathname()->willReturn($docsDir.'/board-games/index.md');

        $b->getRelativePath()->willReturn($docsDir);
        $b->getRelativePathname()->willReturn('books/index.md');
        $b->getPathname()->willReturn($docsDir.'/books/index.md');

        $closure->call($this, $a, $b)->shouldReturn(1);
        $closure->call($this, $b, $a)->shouldReturn(-1);
    }

    function it_allows_to_customize_all_page_position_when_pages_are_on_index_files(SplFileInfo $a, SplFileInfo $b): void
    {
        $closure = $this::sort([
            'books/index.md',
            'board-games/index.md',
        ]);

        $docsDir = __DIR__.'/../../tests/docs';

        $a->getRelativePath()->willReturn($docsDir);
        $a->getRelativePathname()->willReturn('board-games/index.md');
        $a->getPathname()->willReturn($docsDir.'/board-games/index.md');

        $b->getRelativePath()->willReturn($docsDir);
        $b->getRelativePathname()->willReturn('books/index.md');
        $b->getPathname()->willReturn($docsDir.'/books/index.md');

        $closure->call($this, $a, $b)->shouldReturn(1);
        $closure->call($this, $b, $a)->shouldReturn(-1);
    }
}
