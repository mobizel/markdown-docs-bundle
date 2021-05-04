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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class PageCollectionDataProvider implements PageCollectionDataProviderInterface
{
    /** @var ReaderContextInterface */
    private $readerContext;

    /** @var Request */
    private $request;

    public function __construct(ReaderContextInterface $readerContext, RequestStack $requestStack)
    {
        $this->readerContext = $readerContext;
        $this->request = $requestStack->getCurrentRequest() ?? new Request();
    }

    public function getRootPages(): iterable
    {
        $docsDir = $this->getCurrentContext()->getDocsDir($this->request);
        $finder = new Finder();

        $finder
            ->files()
            ->in($docsDir)
            //->notName('index.md')
            ->depth(0)
            ->append($this->createDirectoryIndexFinder($docsDir))
            ->sort(PageSorter::sortByTitle());

        $pages = [];

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            /** @var string $slug */
            $slug = preg_replace('/\.md$/', '', $pageInfo->getRelativePathName());
            $slug = preg_replace('/\/index$/', '', $slug);

            $pages[] = $this->createPage(
                (string) $slug,
                $pageInfo->getTitle(),
                $pageInfo->getContentWithoutTitle()
            );
        }

        return $pages;
    }

    public function getChildrenPages(string $parentSlug): iterable
    {
        $docsDir = $this->getCurrentContext()->getDocsDir($this->request);
        $finder = new Finder();

        try {
            $finder
                ->files()
                ->in($docsDir.'/'.$parentSlug)
                ->notName('index.md')
                ->depth(0)
                ->append($this->createDirectoryIndexFinder($docsDir.'/'.$parentSlug))
                ->sort(PageSorter::sortByTitle());
        } catch (DirectoryNotFoundException $exception) {
            return [];
        }

        $pages = [];

        foreach ($finder as $file) {
            $pageInfo = new PageInfo($file->getPathname(), $file->getRelativePath(), $file->getRelativePathname());

            $slug = $parentSlug.'/'.preg_replace('/\.md$/', '', $file->getRelativePathName());
            $slug = preg_replace('/\/index$/', '', $slug);

            $pages[] = $this->createPage(
                (string) $slug,
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

    public function getPagesAsTree(): array
    {
        $tree = [];

        foreach ($this->getRootPages() as $page) {
            $tree[$page->slug] = [
                'slug' => $page->slug,
                'title' => $page->title,
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
                'children' => $this->addChildrenOnTreeNode($page->slug),
            ];
        }

        return $children;
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
        $docsDir = $this->getCurrentContext()->getDocsDir($this->request);

        // first get Root pages and also homepage
        $finder
            ->files()
            ->in($docsDir)
            ->depth(0)
            ->append($this->createDirectoryIndexFinder($docsDir))
            ->sort(PageSorter::sortByTitle())
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
        $docsDir = $this->getCurrentContext()->getDocsDir($this->request);
        $finder = new Finder();

        try {
            $finder
                ->files()
                ->in($docsDir.'/'.$parentSlug)
                ->notName('index.md')
                ->depth(0)
                ->append($this->createDirectoryIndexFinder($docsDir.'/'.$parentSlug))
                ->sort(PageSorter::sortByTitle())
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

    private function createDirectoryIndexFinder(string $dir): Finder
    {
        return (new Finder())
            ->files()
            ->name('index.md')
            ->in($dir)
            ->depth(1);
    }
}
