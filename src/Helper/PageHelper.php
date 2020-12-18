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

use Webmozart\Assert\Assert;

final class PageHelper implements PageHelperInterface
{
    /** @var array */
    private $pagesMap;

    public function __construct(array $pagesMap)
    {
        $this->pagesMap = $pagesMap;
    }

    public function getTitle(string $slug): string
    {
        return $this->pagesMap[$slug] ?? '';
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
        $currentPosition = array_search($slug, array_keys($this->pagesMap));
        Assert::notFalse($currentPosition, 'Current position was not found');

        return $currentPosition;
    }

    private function getPageFromPosition(int $position): ?string
    {
        /** @var string|null $slug */
        $slug = array_keys($this->pagesMap)[$position] ?? null;

        return $slug;
    }
}
