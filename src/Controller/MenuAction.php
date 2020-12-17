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

use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageCollectionDataProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class MenuAction extends AbstractController
{
    /** @var PageCollectionDataProviderInterface */
    private $pageCollectionDataProvider;

    public function __construct(PageCollectionDataProviderInterface $pageCollectionDataProvider)
    {
        $this->pageCollectionDataProvider = $pageCollectionDataProvider;
    }

    public function __invoke(Request $request): Response
    {
        $menuItems = $this->getMenuItems();
        $currentSubmenuItems = $this->getCurrentSubmenuItems($request);

        return $this->render('@MobizelMarkdownDocs/layout/menu.html.twig', [
            'menu_items' => $menuItems,
            'current_item' => $request->query->get('current_item'),
            'current_sub_menu_items' => $currentSubmenuItems,
        ]);
    }

    private function getMenuItems(): iterable
    {
        return $this->pageCollectionDataProvider->getRootPages();
    }

    private function getCurrentSubmenuItems(Request $request): iterable
    {
        $currentItem = $request->query->get('current_item');
        $currentSubmenuItems = [];

        if (null === $currentItem) {
            return $currentSubmenuItems;
        }

        $parentSlug = explode('/', $currentItem)[0];

        return $this->pageCollectionDataProvider->getChildrenPages($parentSlug);
    }
}
