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

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Dto\PageOutput;
use Mobizel\Bundle\MarkdownDocsBundle\Page\PageInfo;
use Mobizel\Bundle\MarkdownDocsBundle\Page\PageSorter;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;

final class PageCollectionDataProvider implements PageCollectionDataProviderInterface
{
    private ReaderContextInterface $readerContext;

    public function __construct(ReaderContextInterface $readerContext)
    {
        $this->readerContext = $readerContext;
    }

    public function getRootPages(): iterable
    {
        $docsDir = $this->getDocsDir();
        $finder = new Finder();
        $pagesCustomData = $this->getPagesCustomData($docsDir);

        $finder
            ->files()
            ->in($docsDir)
            ->name('*.md')
            //->notName('index.md')
            ->depth(0)
            ->append($this->createDirectoryIndexFinder($docsDir))
            ->sort(PageSorter::sort($this->getPagesCustomData($docsDir)));

        $pages = [];

        foreach ($finder as $file) {
            $customData = $pagesCustomData[$file->getRelativePathname()] ?? [];
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            /** @var string $slug */
            $slug = preg_replace('/\.md$/', '', $pageInfo->getRelativePathName());
            $slug = preg_replace('/\/index$/', '', $slug);

            $pages[] = $this->createPage(
                (string) $slug,
                $pageInfo->getTitle(),
                $pageInfo->getContentWithoutTitle(),
                $customData ?? []
            );
        }

        return $pages;
    }

    public function getChildrenPages(string $parentSlug): iterable
    {
        $docsDir = $this->getDocsDir();
        $finder = new Finder();
        $pagesCustomData = $this->getPagesCustomData($docsDir.'/'.$parentSlug);

        try {
            $finder
                ->files()
                ->in($docsDir.'/'.$parentSlug)
                ->name('*.md')
                ->notName('index.md')
                ->depth(0)
                ->append($this->createDirectoryIndexFinder($docsDir.'/'.$parentSlug))
                ->sort(PageSorter::sort($this->getPagesCustomData($docsDir.'/'.$parentSlug)));
        } catch (DirectoryNotFoundException $exception) {
            return [];
        }

        $pages = [];

        foreach ($finder as $file) {
            $customData = $pagesCustomData[$file->getRelativePathname()] ?? [];
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            $slug = $parentSlug.'/'.preg_replace('/\.md$/', '', $file->getRelativePathName());
            $slug = preg_replace('/\/index$/', '', $slug);

            $pages[] = $this->createPage(
                (string) $slug,
                $pageInfo->getTitle(),
                $pageInfo->getContentWithoutTitle(),
                $customData ?? []
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

    public function getPagesAsTree(): array
    {
        $tree = [];

        foreach ($this->getRootPages() as $page) {
            $tree[$page->slug] = [
                'slug' => $page->slug,
                'title' => $page->title,
                'metadata' => $page->metadata,
                'children' => $this->addChildrenOnTreeNode($page->slug),
            ];
        }

        return $tree;
    }

    private function addChildrenOnTreeNode(string $parentSlug): array
    {
        $children = [];

        foreach ($this->getChildrenPages($parentSlug) as $page) {
            $children[$page->slug] = [
                'slug' => $page->slug,
                'title' => $page->title,
                'metadata' => $page->metadata,
                'children' => $this->addChildrenOnTreeNode($page->slug),
            ];
        }

        return $children;
    }

    private function createPage(string $slug, string $title, string $content, array $metadata = []): PageOutput
    {
        return new PageOutput($slug, $title, $content, null, $metadata);
    }

    private function getRootPagesMap(): array
    {
        $finder = new Finder();
        $docsDir = $this->getDocsDir();

        // first get Root pages and also homepage
        $finder
            ->files()
            ->name('*.md')
            ->in($docsDir)
            ->depth(0)
            ->append($this->createDirectoryIndexFinder($docsDir))
            ->sort(PageSorter::sort($this->getPagesCustomData($docsDir)))
        ;

        $pages = [];

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            /** @var string $slug */
            $slug = preg_replace('/\.md$/', '', $pageInfo->getRelativePathName());
            $slug = preg_replace('/\/index$/', '', $slug);

            $pages[] = ['slug' => $slug, 'title' => $pageInfo->getTitle()];
        }

        return $pages;
    }

    private function getChildrenPagesMap(array $row, array $pages, int &$currentPosition): array
    {
        $parentSlug = $row['slug'];
        $docsDir = $this->getDocsDir();
        $finder = new Finder();

        try {
            $finder
                ->files()
                ->in($docsDir.'/'.$parentSlug)
                ->name('*.md')
                ->notName('index.md')
                ->depth(0)
                ->append($this->createDirectoryIndexFinder($docsDir.'/'.$parentSlug))
                ->sort(PageSorter::sort($this->getPagesCustomData($docsDir.'/'.$parentSlug)))
            ;
        } catch (DirectoryNotFoundException $exception) {
            return $pages;
        }

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());
            $slug = $parentSlug.'/'.preg_replace('/\.md$/', '', $pageInfo->getRelativePathName());
            $slug = preg_replace('/\/index$/', '', $slug);

            $pageToAdd = ['slug' => $slug, 'title' => $pageInfo->getTitle()];

            array_splice($pages, $currentPosition + 1, 0, [$pageToAdd]);
            ++$currentPosition;

            $pages = $this->getChildrenPagesMap($pageToAdd, $pages, $currentPosition);
        }

        return $pages;
    }

    private function getCurrentContext(): ContextInterface
    {
        return $this->readerContext->getContext();
    }

    private function getDocsDir(): string
    {
        return $this->getCurrentContext()->getDocsDir($this->readerContext->getRequest());
    }

    private function createDirectoryIndexFinder(string $dir): Finder
    {
        return (new Finder())
            ->files()
            ->name('index.md')
            ->in($dir)
            ->depth(1);
    }

    private function getPagesCustomData(string $dir): array
    {
        $pageSorterFile = $dir.'/pages.php';

        if (file_exists($pageSorterFile)) {
            $contents = require $pageSorterFile;
            Assert::isArray($contents, sprintf('File "%s" should return an array', $pageSorterFile));

            return $contents;
        }

        return [];
    }
}
