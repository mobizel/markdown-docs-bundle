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

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageItemDataProvider;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\RouteHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PageAction extends AbstractController
{
    /** @var PageItemDataProvider */
    private $pageItemDataProvider;

    /** @var ReaderContextInterface */
    private $readerContext;

    /** @var RouteHelperInterface */
    private $routeHelper;

    public function __construct(
        PageItemDataProvider $pageItemDataProvider,
        ReaderContextInterface $readerContext,
        RouteHelperInterface $routeHelper
    ) {
        $this->pageItemDataProvider = $pageItemDataProvider;
        $this->readerContext = $readerContext;
        $this->routeHelper = $routeHelper;
    }

    public function __invoke(Request $request, string $slug): Response
    {
        $context = $this->readerContext->getContext();

        // redirect a suffixed page ("foo/bar.md" should be redirected to "foo/bar")
        if (false !== strpos($slug, '.md')) {
            $slug = preg_replace('/\.md$/', '', $slug);

            return $this->redirect($this->routeHelper->getPathForPage($context, $slug));
        }

        // redirect a directory homepage ("foo/bar/index" should be redirected to "foo/bar")
        if (false !== strpos($slug, '/index')) {
            $slug = preg_replace('/\/index$/', '', $slug);

            return $this->redirect($this->routeHelper->getPathForPage($context, $slug));
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
