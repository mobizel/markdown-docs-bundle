<?php

/*
 * This file is part of the markdown-docs-bundle project.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

final class RouteHelper implements RouteHelperInterface
{
    /** @var Request */
    private $request;

    /** @var RouterInterface */
    private $router;

    public function __construct(RequestStack $requestStack, RouterInterface $router)
    {
        $this->request = $requestStack->getCurrentRequest() ?? new Request();
        $this->router = $router;
    }

    public function getRouteForIndex(ContextInterface $context): string
    {
        return sprintf('mobizel_markdown_docs_%s_index', $context->getName());
    }

    public function getRouteForPage(ContextInterface $context): string
    {
        return sprintf('mobizel_markdown_docs_%s_page_show', $context->getName());
    }

    public function getRouteForMenu(ContextInterface $context): string
    {
        return sprintf('mobizel_markdown_docs_%s_menu', $context->getName());
    }

    public function getRouteForSearch(ContextInterface $context): string
    {
        return sprintf('mobizel_markdown_docs_%s_search', $context->getName());
    }

    public function getPathForPage(ContextInterface $context, string $slug): string
    {
        $route = $this->getRouteForPage($context);

        $routeParameters = $this->request->get('_route_params');
        $routeParameters['slug'] = $slug;

        return $this->router->generate($route, $routeParameters);
    }

    public function getPathForSearch(ContextInterface $context): string
    {
        $route = $this->getRouteForSearch($context);

        $routeParameters = $this->request->get('_route_params');
        unset($routeParameters['slug']);

        return $this->router->generate($route, $routeParameters);
    }
}
