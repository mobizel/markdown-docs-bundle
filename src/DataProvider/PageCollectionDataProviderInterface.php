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

namespace Mobizel\Bundle\MarkdownDocsBundle\DataProvider;

use Mobizel\Bundle\MarkdownDocsBundle\Dto\PageOutput;

interface PageCollectionDataProviderInterface
{
    /** @return iterable<int, PageOutput> */
    public function getPages(): iterable;

    /** @return iterable<int, PageOutput> */
    public function getRootPages(): iterable;

    /** @return iterable<int, PageOutput> */
    public function getChildrenPages(string $parentSlug): iterable;

    /** @return array<string, string> */
    public function getPagesMap(): array;

    public function getPagesAsTree(): array;
}
