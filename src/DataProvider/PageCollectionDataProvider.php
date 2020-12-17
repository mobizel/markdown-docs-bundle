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
use Mobizel\Bundle\MarkdownDocsBundle\Page\PageSorter;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

final class PageCollectionDataProvider implements PageCollectionDataProviderInterface
{
    /** @var string */
    private $docsDir;

    public function __construct(string $docsDir)
    {
        $this->docsDir = $docsDir;
    }

    public function getRootPages(): iterable
    {
        $finder = new Finder();

        $finder
            ->files()
            ->in($this->docsDir)
            ->notName('index.md')
            ->depth(0)
            ->sort(PageSorter::sortByTitle());

        $pages = [];

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            $pages[] = $this->createPage(
                preg_replace('/\.md$/', '', $pageInfo->getRelativePathName()),
                $pageInfo->getTitle(),
                $pageInfo->getContentWithoutTitle()
            );
        }

        return $pages;
    }

    public function getChildrenPages(string $parentSlug): iterable
    {
        $finder = new Finder();

        try {
            $finder
                ->files()
                ->in($this->docsDir.'/'.$parentSlug)
                ->notName('index.md')
                ->depth(0)
                ->sort(PageSorter::sortByTitle());
        } catch (DirectoryNotFoundException $exception) {
            return [];
        }

        $pages = [];

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            $pages[] = $this->createPage(
                $parentSlug.'/'.preg_replace('/\.md$/', '', $file->getRelativePathName()),
                $pageInfo->getTitle(),
                $pageInfo->getContentWithoutTitle()
            );
        }

        return $pages;
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
