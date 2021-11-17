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
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class PageItemDataProvider
{
    private TemplateResolverInterface $templateResolver;

    public function __construct(TemplateResolverInterface $templateResolver)
    {
        $this->templateResolver = $templateResolver;
    }

    public function getPage(Request $request): ?PageOutput
    {
        $slug = $request->attributes->get('slug', '');

        Assert::string($slug, 'Slug must be a string. Got: %s');

        $templatePath = $this->templateResolver->resolve($request);

        if (null === $templatePath) {
            return null;
        }

        $pageInfo = new PageInfo($templatePath, dirname($slug), $slug.'.md');

        return $this->createPage(
            $slug,
            $pageInfo->getTitle(),
            $pageInfo->getContentWithoutTitle(),
            $pageInfo->getTableOfContents()
        );
    }

    private function createPage(string $slug, string $title, string $content, string $tableOfContents = null): PageOutput
    {
        return new PageOutput($slug, $title, $content, $tableOfContents);
    }
}
