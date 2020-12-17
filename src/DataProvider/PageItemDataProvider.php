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

namespace Mobizel\Bundle\MarkdownDocsBundle\DataProvider;

use Mobizel\Bundle\MarkdownDocsBundle\Dto\PageOutput;
use Mobizel\Bundle\MarkdownDocsBundle\Page\PageInfo;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;

final class PageItemDataProvider
{
    /** @var TemplateHandlerInterface */
    private $templateHandler;

    public function __construct(TemplateHandlerInterface $templateHandler)
    {
        $this->templateHandler = $templateHandler;
    }

    public function getPage(string $slug): ?PageOutput
    {
        $templateAbsolutePath = $this->templateHandler->getTemplateAbsolutePath($slug);

        if (!is_file($templateAbsolutePath)) {
            return null;
        }

        $pageInfo = new PageInfo($templateAbsolutePath, dirname($slug), $this->templateHandler->getTemplatePath($slug));

        return $this->createPage(
            $slug,
            $pageInfo->getTitle(),
            $pageInfo->getContentWithoutTitle(),
        );
    }

    private function createPage(string $slug, string $title, string $content): PageOutput
    {
        $page = new PageOutput();
        $page->slug = $slug;
        $page->title = $title;
        $page->content = $content;

        return $page;
    }
}
