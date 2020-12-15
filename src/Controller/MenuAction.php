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

namespace Mobizel\Bundle\MarkdownDocsBundle\Controller;

use Mobizel\Bundle\MarkdownDocsBundle\Helper\PageHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class MenuAction extends AbstractController
{
    /** @var string */
    private $docsDir;

    /** @var PageHelperInterface */
    private $pageHelper;

    public function __construct(string $docsDir, PageHelperInterface $pageHelper)
    {
        $this->docsDir = $docsDir;
        $this->pageHelper = $pageHelper;
    }

    public function __invoke(Request $request): Response
    {
        $menuItems = $this->getMenuItems($request);
        $currentSubmenuItems = $this->getCurrentSubmenuItems($request);

        return $this->render('@MobizelMarkdownDocs/layout/menu.html.twig', [
            'menu_items' => $menuItems,
            'current_item' => $request->query->get('current_item'),
            'current_sub_menu_items' => $currentSubmenuItems,
        ]);
    }

    private function getMenuItems(Request $request): array
    {
        $finder = new Finder();

        $finder->files()->in($this->docsDir)->depth(0)->notName('index.md')->sort($this::sortByTitle());

        $menuItems = [];

        foreach ($finder as $file) {
            $slug = preg_replace('/\.md$/', '', $file->getRelativePathName());
            $menuItems[] = [
                'slug' => $slug,
                'path' => $this->generateUrl('mobizel_markdown_docs_page_show', ['slug' => $slug]),
            ];
        }

        return $menuItems;
    }

    private function getCurrentSubmenuItems(Request $request): array
    {
        $currentItem = $request->query->get('current_item');
        $currentSubmenuItems = [];

        if (null === $currentItem) {
            return $currentSubmenuItems;
        }

        $rootSlug = explode('/', $currentItem)[0];
        $finder = new Finder();
        try {
            $finder->files()->in($this->docsDir.'/'.$rootSlug)->depth(0)->sort($this->sortByTitle($rootSlug));
        } catch (DirectoryNotFoundException $exception) {
            return [];
        }

        foreach ($finder as $file) {
            $slug = $rootSlug.'/'.preg_replace('/\.md$/', '', $file->getRelativePathName());
            $currentSubmenuItems[] = [
                'slug' => $slug,
                'path' => $this->generateUrl('mobizel_markdown_docs_page_show', ['slug' => $slug]),
            ];
        }

        return $currentSubmenuItems;
    }

    private function sortByTitle(string $rootSlug = null): \Closure
    {
        return function (\SplFileInfo $first, \SplFileInfo $second) use ($rootSlug) {
            $firstSlug = preg_replace('/\.md$/', '', $first->getRelativePathName());

            if (null !== $rootSlug) {
                $firstSlug = $rootSlug.'/'.$firstSlug;
            }

            $firstTitle = $this->pageHelper->getTitle($firstSlug);

            $secondSlug = preg_replace('/\.md$/', '', $second->getRelativePathName());

            if (null !== $rootSlug) {
                $secondSlug = $rootSlug.'/'.$secondSlug;
            }

            $secondTitle = $this->pageHelper->getTitle($secondSlug);

            return 1 * strcmp($firstTitle, $secondTitle);
        };
    }
}
