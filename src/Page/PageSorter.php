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
    public static function sortByTitle(): \Closure
    {
        return function (SplFileInfo $a, SplFileInfo $b) {
            $secondPageSlug = preg_replace('/\.md$/', '', $b->getRelativePathName());
            $firstPageSlug = preg_replace('/\.md$/', '', $a->getRelativePathName());

            // Homepage is always the first page
            if ('index' === $secondPageSlug) {
                return 1;
            }

            if ('index' == $firstPageSlug) {
                return -1;
            }

            $firstPage = new PageInfo($a->getPathname(), $a->getRelativePath(), $a->getRelativePathname());
            $secondPage = new PageInfo($b->getPathname(), $b->getRelativePath(), $b->getRelativePathname());

            return 1 * strcmp($firstPage->getTitle(), $secondPage->getTitle());
        };
    }
}
