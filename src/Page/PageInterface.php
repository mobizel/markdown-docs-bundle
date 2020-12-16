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

interface PageInterface
{
    public function getTitle(): string;

    public function getContent(): string;

    public function getContentWithoutTitle(): string;
}
