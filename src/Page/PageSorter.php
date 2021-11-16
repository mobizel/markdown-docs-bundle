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

namespace Mobizel\Bundle\MarkdownDocsBundle\Page;

use Symfony\Component\Finder\SplFileInfo;

final class PageSorter
{
    public static function sort(array $pageSorterContents = []): \Closure
    {
        return function (SplFileInfo $a, SplFileInfo $b) use ($pageSorterContents) {
            $secondPageSlug = preg_replace('/\.md$/', '', $b->getRelativePathName());
            $firstPageSlug = preg_replace('/\.md$/', '', $a->getRelativePathName());

            dump($secondPageSlug);
            dump($firstPageSlug);
            dump($pageSorterContents);

            // Homepage is always the first page
            if ('index' === $secondPageSlug) {
                dump('Homepage is always the first page');
                return 1;
            }

            if ('index' === $firstPageSlug) {
                dump('Homepage is always the first page');
                return -1;
            }

            $firstPagePosition = array_search($a->getRelativePathname(), $pageSorterContents);

            if (false === $firstPagePosition) {
                $firstPagePosition = array_search($a->getRelativePathname(), array_keys($pageSorterContents));
            }

            $secondPagePosition = array_search($b->getRelativePathname(), $pageSorterContents);

            if (false === $secondPagePosition) {
                $secondPagePosition = array_search($b->getRelativePathname(), array_keys($pageSorterContents));
            }

            // two files are on custom page position file
            if (false !== $firstPagePosition && false !== $secondPagePosition) {
                dump('two files are on custom page position file');
                $order = $firstPagePosition > $secondPagePosition ? 1 : -1;

                return 1 * $order;
            }

            // only the first file to compare is on custom page position file
            // so place it before
            if (false !== $firstPagePosition) {
                dump('only the first file to compare is on custom page position file');
                return -1;
            }

            // only the second file to compare is on custom page position file
            // so place it after
            if (false !== $secondPagePosition) {
                dump('only the second file to compare is on custom page position file');
                return 1;
            }

            $firstPage = new PageInfo($a->getPathname(), $a->getRelativePath(), $a->getRelativePathname());
            $secondPage = new PageInfo($b->getPathname(), $b->getRelativePath(), $b->getRelativePathname());

            return 1 * strcmp($firstPage->getTitle(), $secondPage->getTitle());
        };
    }
}
