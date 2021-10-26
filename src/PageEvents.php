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

namespace Mobizel\Bundle\MarkdownDocsBundle;

final class PageEvents
{
    /**
     * The VIEW event occurs before rendering page.
     *
     * @Event("Mobizel\Bundle\MarkdownDocsBundle\Event\PageEvent")
     */
    public const VIEW = 'markdown_docs.page.view';
}
