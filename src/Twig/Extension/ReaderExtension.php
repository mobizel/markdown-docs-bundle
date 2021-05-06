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

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\RouteHelperInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ReaderExtension extends AbstractExtension implements ReaderExtensionInterface
{
    /** @var ReaderContextInterface */
    private $readerContext;

    /** @var RouteHelperInterface */
    private $routeHelper;

    public function __construct(
        ReaderContextInterface $readerContext,
        RouteHelperInterface $routeHelper
    ) {
        $this->readerContext = $readerContext;
        $this->routeHelper = $routeHelper;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('path_for_index', [$this, 'getPathForIndex']),
            new TwigFunction('path_for_menu', [$this, 'getPathForMenu']),
            new TwigFunction('path_for_page', [$this, 'getPathForPage']),
            new TwigFunction('path_for_search', [$this, 'getPathForSearch']),
            new TwigFunction('metadata', [$this, 'getMetadata']),
        ];
    }

    public function getPathForIndex(): string
    {
        return $this->routeHelper->getPathForIndex($this->readerContext->getContext());
    }

    public function getPathForMenu(): string
    {
        return $this->routeHelper->getPathForMenu($this->readerContext->getContext());
    }

    public function getPathForPage(string $slug): string
    {
        return $this->routeHelper->getPathForPage($this->readerContext->getContext(), $slug);
    }

    public function getPathForSearch(): string
    {
        return $this->routeHelper->getPathForSearch($this->readerContext->getContext());
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata(string $key)
    {
        $request = $this->readerContext->getRequest();

        return $this->readerContext->getContext()->getMetadata($request)[$key] ?? null;
    }
}
