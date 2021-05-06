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

namespace Mobizel\Bundle\MarkdownDocsBundle\Routing;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextRegistryInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\RouteHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class ContextLoader
{
    /** @var ContextRegistryInterface */
    private $contextRegistry;

    /** @var RouteHelperInterface */
    private $routeHelper;

    public function __construct(ContextRegistryInterface $contextRegistry, RouteHelperInterface $routeHelper)
    {
        $this->contextRegistry = $contextRegistry;
        $this->routeHelper = $routeHelper;
    }

    public function __invoke(): RouteCollection
    {
        $routeCollection = new RouteCollection();

        /**
         * @var ContextInterface $context
         */
        foreach ($this->contextRegistry->getAll() as $context) {
            $this->addRoutesForContext($routeCollection, $context);
        }

        return $routeCollection;
    }

    private function addRoutesForContext(RouteCollection $routeCollection, ContextInterface $context)
    {
        $this->addRouteForMenu($routeCollection, $context);
        $this->addRouteForSearch($routeCollection, $context);
        $this->addRouteForIndex($routeCollection, $context);
        $this->addRouteForPage($routeCollection, $context);
    }

    private function addRouteForMenu(RouteCollection $routeCollection, ContextInterface $context)
    {
        $defaults = ['_controller' => 'mobizel_markdown_docs.controller.menu_action'];

        $route = new Route($context->getPath().'/menu', $defaults, [], [], null, [], [Request::METHOD_GET]);
        $routeCollection->add($this->routeHelper->getRouteForMenu($context), $route);
    }

    private function addRouteForSearch(RouteCollection $routeCollection, ContextInterface $context)
    {
        $defaults = ['_controller' => 'mobizel_markdown_docs.controller.search_action'];

        $route = new Route($context->getPath().'/search', $defaults, [], [], null, [], [Request::METHOD_GET]);
        $routeCollection->add($this->routeHelper->getRouteForSearch($context), $route);
    }

    private function addRouteForIndex(RouteCollection $routeCollection, ContextInterface $context)
    {
        $defaults = ['_controller' => 'mobizel_markdown_docs.controller.index_action'];

        $route = new Route($context->getPath().'/', $defaults, [], [], null, [], [Request::METHOD_GET]);
        $routeCollection->add($this->routeHelper->getRouteForIndex($context), $route);
    }

    private function addRouteForPage(RouteCollection $routeCollection, ContextInterface $context)
    {
        $defaults = [
            '_controller' => 'mobizel_markdown_docs.controller.page_action',
            'trailingSlash' => null,
        ];

        $requirements = [
            'slug' => '.+(?<!/)',
            'trailingSlash' => '\/?$', // allow trailing slash if a directory with the same name exists on public
        ];

        $route = new Route($context->getPath().'/{slug}{trailingSlash}', $defaults, $requirements, [], null, [], [Request::METHOD_GET]);
        $routeCollection->add($this->routeHelper->getRouteForPage($context), $route);
    }
}
