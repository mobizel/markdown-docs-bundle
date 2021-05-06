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

namespace Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension;

use Mobizel\Bundle\MarkdownDocsBundle\Helper\PageHelperInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class PaginationExtension extends AbstractExtension implements PaginationExtensionInterface
{
    /** @var PageHelperInterface */
    private $pageHelper;

    public function __construct(PageHelperInterface $pageHelper)
    {
        $this->pageHelper = $pageHelper;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('previous_page', [$this, 'previousPage']),
            new TwigFunction('next_page', [$this, 'nextPage']),
        ];
    }

    public function previousPage(string $slug): ?string
    {
        return $this->pageHelper->getPreviousPage($slug);
    }

    public function nextPage(string $slug): ?string
    {
        return $this->pageHelper->getNextPage($slug);
    }
}
