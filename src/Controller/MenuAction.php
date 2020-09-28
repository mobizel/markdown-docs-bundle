<?php

/*
 * This file is part of markdown-docs.
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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MenuAction extends AbstractController
{
    /** @var string */
    private $docsDir;

    public function __construct(string $docsDir)
    {
        $this->docsDir = $docsDir;
    }

    /**
     * @Route(path="/menu", name="menu")
     */
    public function __invoke(): Response
    {
        $finder = new Finder();
        $finder->files()->in($this->docsDir)->depth(0)->notName('index.md');

        $menuItems = [];
        $docs = basename($this->docsDir);

        foreach($finder as $file) {
            $slug = $docs.'/'.rtrim($file->getRelativePathName(),'.md');
            $menuItems[] = [
                'slug' => $slug,
                'path' => '/'.$slug,
            ];
        }

        return $this->render('@MobizelMarkdownDocs/layout/menu.html.twig', ['menu_items' => $menuItems]);
    }
}
