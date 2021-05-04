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

use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageItemDataProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PageAction extends AbstractController
{
    /** @var PageItemDataProvider */
    private $pageItemDataProvider;

    public function __construct(
        PageItemDataProvider $pageItemDataProvider
    ) {
        $this->pageItemDataProvider = $pageItemDataProvider;
    }

    public function __invoke(Request $request, string $slug): Response
    {
        /** @var string $slug */
        $slug = preg_replace('/\/$/', '', $slug);

        // redirect a suffixed page ("foo/bar.md" should be redirected to "foo/bar")
        if (false !== strpos($slug, '.md')) {
            $slug = preg_replace('/\.md$/', '', $slug);

            return $this->redirectToRoute('mobizel_markdown_docs_page_show', ['slug' => $slug]);
        }

        // redirect a directory homepage ("foo/bar/index" should be redirected to "foo/bar")
        if (false !== strpos($slug, '/index')) {
            $slug = preg_replace('/\/index$/', '', $slug);

            return $this->redirectToRoute('mobizel_markdown_docs_page_show', ['slug' => $slug]);
        }

        $page = $this->pageItemDataProvider->getPage($request);

        if (null === $page) {
            throw new NotFoundHttpException(sprintf('Page "%s" was not found', $slug));
        }

        return $this->render('@MobizelMarkdownDocs/page/show.html.twig', [
            'page' => $page,
        ]);
    }
}
