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

namespace Mobizel\Bundle\MarkdownDocsBundle\Dto;

final class PageOutput
{
    public string $slug;
    public string $title;
    public string $content;
    public ?string $tableOfContents = null;

    public function __construct(
        string $slug,
        string $title,
        string $content,
        ?string $tableOfContents = null
    ) {
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
        $this->tableOfContents = $tableOfContents;
    }
}
