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
use Mobizel\Bundle\MarkdownDocsBundle\Dto\ImageResponse;
use Mobizel\Bundle\MarkdownDocsBundle\Event\PageEvent;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\RouteHelperInterface;
use Mobizel\Bundle\MarkdownDocsBundle\PageEvents;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress TooManyArguments
 */
final class PageAction extends AbstractController
{
    private PageItemDataProvider $pageItemDataProvider;
    private ReaderContextInterface $readerContext;
    private RouteHelperInterface $routeHelper;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        PageItemDataProvider $pageItemDataProvider,
        ReaderContextInterface $readerContext,
        RouteHelperInterface $routeHelper,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->pageItemDataProvider = $pageItemDataProvider;
        $this->readerContext = $readerContext;
        $this->routeHelper = $routeHelper;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Request $request, string $slug): Response
    {
        $context = $this->readerContext->getContext();

        /// send image response if page ends with .jpeg ("foo/page.jpg" should be send as image )
        if( $this->isJpegImage($slug)){
            $image = file_get_contents($context->getDocsDir($request).DIRECTORY_SEPARATOR.$slug);
            return new ImageResponse($image,200);
        }
        // redirect a suffixed page ("foo/bar.md" should be redirected to "foo/bar")
        if (false !== strpos($slug, '.md')) {
            /** @var string $slug */
            $slug = preg_replace('/\.md$/', '', $slug);

            return $this->redirect($this->routeHelper->getPathForPage($context, $slug));
        }

        // redirect a directory homepage ("foo/bar/index" should be redirected to "foo/bar")
        if (false !== strpos($slug, '/index')) {
            /** @var string $slug */
            $slug = preg_replace('/\/index$/', '', $slug);

            return $this->redirect($this->routeHelper->getPathForPage($context, $slug));
        }

        $page = $this->pageItemDataProvider->getPage($request);
        if (null === $page) {
            throw new NotFoundHttpException(sprintf('Page "%s" was not found', $slug));
        }

        $this->eventDispatcher->dispatch(new PageEvent($request, $page, $context), PageEvents::VIEW);

        return $this->render('@MobizelMarkdownDocs/page/show.html.twig', [
            'page' => $page,
        ]);
    }


    private function isJpegImage(string $slug): bool
    {
        $chunks = explode(".",$slug);
        $extension = end($chunks);
        return "jpeg" === $extension;
    }
}
