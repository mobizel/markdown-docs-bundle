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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class MenuAction extends AbstractController
{
    /** @var string */
    private $docsDir;

    public function __construct(string $docsDir)
    {
        $this->docsDir = $docsDir;
    }

    public function __invoke(Request $request): Response
    {
        $finder = new Finder();
        $finder->files()->in($this->docsDir)->depth(0)->notName('index.md');

        $menuItems = [];

        foreach ($finder as $file) {
            $slug = preg_replace('/\.md$/', '', $file->getRelativePathName());
            $menuItems[] = [
                'slug' => $slug,
                'path' => $this->generateUrl('mobizel_markdown_docs_page_show', ['slug' => $slug]),
            ];
        }

        return $this->render('@MobizelMarkdownDocs/layout/menu.html.twig', [
            'menu_items' => $menuItems,
            'current_item' => $request->query->get('current_item'),
        ]);
    }
}
