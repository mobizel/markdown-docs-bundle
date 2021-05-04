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

final class IndexAction extends AbstractController
{
    /** @var ReaderContextInterface */
    private $readerContext;

    /** @var RouteHelperInterface */
    private $routeHelper;

    public function __construct(ReaderContextInterface $readerContext, RouteHelperInterface $routeHelper)
    {
        $this->readerContext = $readerContext;
        $this->routeHelper = $routeHelper;
    }

    public function __invoke(): Response
    {
        $context = $this->readerContext->getContext();

        return $this->redirect($this->routeHelper->getPathForPage($context, 'index'));
    }
}
