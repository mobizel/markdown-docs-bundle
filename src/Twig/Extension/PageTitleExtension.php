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

final class PageTitleExtension extends AbstractExtension implements PageTitleExtensionInterface
{
    /** @var PageHelperInterface */
    private $pageHelper;

    public function __construct(PageHelperInterface $pageHelper)
    {
        $this->pageHelper = $pageHelper;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('page_title', [$this, 'pageTitle']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function pageTitle(string $slug): string
    {
        return $this->pageHelper->getTitle($slug);
    }
}
