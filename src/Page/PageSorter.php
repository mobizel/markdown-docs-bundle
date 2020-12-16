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
            $firstPage = new Page($a->getPathname());
            $secondPage = new Page($b->getPathname());

            return 1 * strcmp($firstPage->getTitle(), $secondPage->getTitle());
        };
    }
}
