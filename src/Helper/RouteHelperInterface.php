<?php

/*
 * This file is part of the markdown-docs-bundle project.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;

interface RouteHelperInterface
{
    public function getRouteForIndex(ContextInterface $context): string;

    public function getRouteForPage(ContextInterface $context): string;

    public function getRouteForMenu(ContextInterface $context): string;

    public function getRouteForSearch(ContextInterface $context): string;

    public function getPathForIndex(ContextInterface $context): string;

    public function getPathForMenu(ContextInterface $context): string;

    public function getPathForPage(ContextInterface $context, string $slug): string;

    public function getPathForSearch(ContextInterface $context): string;
}
