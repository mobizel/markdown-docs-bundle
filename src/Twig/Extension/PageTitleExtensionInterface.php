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

use Twig\Extension\ExtensionInterface;

interface PageTitleExtensionInterface extends ExtensionInterface
{
    public function pageTitle(string $slug): string;
}
