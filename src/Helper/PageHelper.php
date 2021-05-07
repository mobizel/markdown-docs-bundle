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

namespace Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageCollectionDataProviderInterface;
use Webmozart\Assert\Assert;

final class PageHelper implements PageHelperInterface
{
    private PageCollectionDataProviderInterface $pageCollectionDataProvider;

    public function __construct(PageCollectionDataProviderInterface $pageCollectionDataProvider)
    {
        $this->pageCollectionDataProvider = $pageCollectionDataProvider;
    }

    public function getTitle(string $slug): string
    {
        return $this->getPagesMap()[$slug] ?? '';
    }

    public function getPreviousPage(string $slug): ?string
    {
        $currentPosition = $this->getCurrentPosition($slug);

        return $this->getPageFromPosition($currentPosition - 1);
    }

    public function getNextPage(string $slug): ?string
    {
        $currentPosition = $this->getCurrentPosition($slug);

        return $this->getPageFromPosition($currentPosition + 1);
    }

    private function getCurrentPosition(string $slug): int
    {
        /** @var int $currentPosition */
        $currentPosition = array_search($slug, array_keys($this->getPagesMap()));

        /* @psalm-suppress RedundantConditionGivenDocblockType */
        Assert::notFalse($currentPosition, 'Current position was not found');

        return $currentPosition;
    }

    private function getPageFromPosition(int $position): ?string
    {
        /** @var string|null $slug */
        $slug = array_keys($this->getPagesMap())[$position] ?? null;

        return $slug;
    }

    private function getPagesMap(): array
    {
        return $this->pageCollectionDataProvider->getPagesMap();
    }
}
