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
use Mobizel\Bundle\MarkdownDocsBundle\Helper\RouteHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class IndexAction extends AbstractController
{
    private ReaderContextInterface $readerContext;
    private RouteHelperInterface $routeHelper;

    public function __construct(ReaderContextInterface $readerContext, RouteHelperInterface $routeHelper)
    {
        $this->readerContext = $readerContext;
        $this->routeHelper = $routeHelper;
    }

    public function __invoke(): Response
    {
        try {
            $context = $this->readerContext->getContext();
        } catch (\InvalidArgumentException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        return $this->redirect($this->routeHelper->getPathForPage($context, 'index'));
    }
}
