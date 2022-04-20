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

namespace Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Webmozart\Assert\Assert;

final class RouteHelper implements RouteHelperInterface
{
    private Request $request;
    private RouterInterface $router;

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

    public function getRouteForPrint(ContextInterface $context): string
    {
        return sprintf('mobizel_markdown_docs_%s_print', $context->getName());
    }

    public function getPathForIndex(ContextInterface $context): string
    {
        $route = $this->getRouteForIndex($context);

        $routeParameters = $this->getRouteParameters();

        unset($routeParameters['slug']);

        return $this->router->generate($route, $routeParameters);
    }

    public function getPathForMenu(ContextInterface $context): string
    {
        $route = $this->getRouteForMenu($context);

        $routeParameters = $this->getRouteParameters();

        $routeParameters['current_item'] = $routeParameters['slug'] ?? null;
        unset($routeParameters['slug']);

        return $this->router->generate($route, $routeParameters);
    }

    public function getPathForPrint(ContextInterface $context): string
    {
        $route = $this->getRouteForPrint($context);

        $routeParameters = $this->getRouteParameters();

        unset($routeParameters['current_item']);
        unset($routeParameters['trailingSlash']);
        unset($routeParameters['slug']);

        return $this->router->generate($route, $routeParameters);
    }

    public function getPathForPage(ContextInterface $context, string $slug): string
    {
        $route = $this->getRouteForPage($context);

        $routeParameters = $this->getRouteParameters();

        $routeParameters['slug'] = $slug;
        unset($routeParameters['trailingSlash']);

        return $this->router->generate($route, $routeParameters);
    }

    public function getPathForSearch(ContextInterface $context): string
    {
        $route = $this->getRouteForSearch($context);

        $routeParameters = $this->getRouteParameters();
        unset($routeParameters['slug']);

        return $this->router->generate($route, $routeParameters);
    }

    private function getRouteParameters(): array
    {
        $routeParameters = $this->request->attributes->get('_route_params');

        Assert::isArray($routeParameters, 'Route params must be an array. Got: %s');

        return $routeParameters;
    }
}
