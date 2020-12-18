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

            /** @var string $slug */
            $slug = preg_replace('/\.md$/', '', $pageInfo->getRelativePathName());

            $pages[] = $this->createPage(
                $slug,
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

            $slug = $parentSlug.'/'.preg_replace('/\.md$/', '', $file->getRelativePathName());

            $pages[] = $this->createPage(
                $slug,
                $pageInfo->getTitle(),
                $pageInfo->getContentWithoutTitle()
            );
        }

        return $pages;
    }

    public function getPagesMap(): array
    {
        $pages = $this->getRootPagesMap();

        $currentPosition = 0;
        foreach ($pages as $row) {
            $pages = $this->getChildrenPagesMap($row, $pages, $currentPosition);
            ++$currentPosition;
        }

        $pagesMap = [];
        foreach ($pages as $row) {
            $pagesMap[$row['slug']] = $row['title'];
        }

        return $pagesMap;
    }

    private function createPage(string $slug, string $title, string $content): PageOutput
    {
        $page = new PageOutput();
        $page->slug = $slug;
        $page->title = $title;
        $page->content = $content;

        return $page;
    }

    private function getRootPagesMap(): array
    {
        $finder = new Finder();

        // first get Root pages and also homepage
        $finder
            ->files()
            ->in($this->docsDir)
            ->depth(0)
            ->sort(PageSorter::sortByTitle())
        ;

        $pages = [];

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            /** @var string $slug */
            $slug = preg_replace('/\.md$/', '', $pageInfo->getRelativePathName());

            $pages[] = ['slug' => $slug, 'title' => $pageInfo->getTitle()];
        }

        return $pages;
    }

    private function getChildrenPagesMap(array $row, array $pages, int &$currentPosition): array
    {
        $parentSlug = $row['slug'];
        $finder = new Finder();

        try {
            $finder
                ->files()
                ->in($this->docsDir.'/'.$parentSlug)
                ->depth(0)
                ->sort(PageSorter::sortByTitle())
            ;
        } catch (DirectoryNotFoundException $exception) {
            return $pages;
        }

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());
            $slug = $parentSlug.'/'.preg_replace('/\.md$/', '', $pageInfo->getRelativePathName());

            $pageToAdd = ['slug' => $slug, 'title' => $pageInfo->getTitle()];

            array_splice($pages, $currentPosition + 1, 0, [$pageToAdd]);
            ++$currentPosition;

            $pages = $this->getChildrenPagesMap($pageToAdd, $pages, $currentPosition);
        }

        return $pages;
    }
}
