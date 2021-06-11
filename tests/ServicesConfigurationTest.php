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

namespace Mobizel\Bundle\MarkdownDocsBundle\Tests;

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContext;
use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Controller\IndexAction;
use Mobizel\Bundle\MarkdownDocsBundle\Controller\MenuAction;
use Mobizel\Bundle\MarkdownDocsBundle\Controller\PageAction;
use Mobizel\Bundle\MarkdownDocsBundle\Controller\SearchAction;
use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageCollectionDataProvider;
use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageCollectionDataProviderInterface;
use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageItemDataProvider;
use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageItemDataProviderInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextRegistry;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextRegistryInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextResolver;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextResolverInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\PageHelper;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\PageHelperInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\RouteHelper;
use Mobizel\Bundle\MarkdownDocsBundle\Helper\RouteHelperInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Markdown\MarkdownExtra;
use Mobizel\Bundle\MarkdownDocsBundle\Routing\ContextLoader;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateResolver;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateResolverInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\PageTitleExtension;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\PageTitleExtensionInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\PaginationExtension;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\PaginationExtensionInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\ReaderExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ServicesConfigurationTest extends KernelTestCase
{
    public function testMarkdownExtraWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $markdownExtra = $container->get('mobizel_markdown_docs.markdown_extra');
        $this->assertInstanceOf(MarkdownExtra::class, $markdownExtra);
    }

    public function testTemplateResolverWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $templateResolver = $container->get('mobizel_markdown_docs.template.template_resolver');
        $this->assertInstanceOf(TemplateResolver::class, $templateResolver);
        $this->assertTrue($container->has(TemplateResolverInterface::class));
    }

    public function testPageHelperWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $pageHelper = $container->get('mobizel_markdown_docs.helper.page_helper');
        $this->assertInstanceOf(PageHelper::class, $pageHelper);
        $this->assertTrue($container->has(PageHelperInterface::class));
    }

    public function testRouteHelperWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $routeHelper = $container->get('mobizel_markdown_docs.helper.route_helper');
        $this->assertInstanceOf(RouteHelper::class, $routeHelper);
        $this->assertTrue($container->has(RouteHelperInterface::class));
    }

    public function testReaderContextWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $readerContext = $container->get('mobizel_markdown_docs.context.reader');
        $this->assertInstanceOf(ReaderContext::class, $readerContext);
        $this->assertTrue($container->has(ReaderContextInterface::class));
    }

    public function testContextRegistryWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $contextRegistry = $container->get('mobizel_markdown_docs.docs.context_registry');
        $this->assertInstanceOf(ContextRegistry::class, $contextRegistry);
        $this->assertTrue($container->has(ContextRegistryInterface::class));
    }

    public function testContextResolverWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $contextResolver = $container->get('mobizel_markdown_docs.docs.context_resolver');
        $this->assertInstanceOf(ContextResolver::class, $contextResolver);
        $this->assertTrue($container->has(ContextResolverInterface::class));
    }

    public function testPageCollectionDataProviderWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $pageCollectionDataProvider = $container->get('mobizel_markdown_docs.data_provider.page_collection');
        $this->assertInstanceOf(PageCollectionDataProvider::class, $pageCollectionDataProvider);
        $this->assertTrue($container->has(PageCollectionDataProviderInterface::class));
    }

    public function testPageItemDataProviderWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $pageItemDataProvider = $container->get('mobizel_markdown_docs.data_provider.page_item');
        $this->assertInstanceOf(PageItemDataProvider::class, $pageItemDataProvider);
        $this->assertTrue($container->has(PageItemDataProviderInterface::class));
    }

    public function testPageTitleExtensionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $pageTitleExtension = $container->get('mobizel_markdown_docs.twig.extension.page_title');
        $this->assertInstanceOf(PageTitleExtension::class, $pageTitleExtension);
        $this->assertTrue($container->has(PageTitleExtensionInterface::class));
    }

    public function testPaginationExtensionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $paginationExtension = $container->get('mobizel_markdown_docs.twig.extension.pagination');
        $this->assertInstanceOf(PaginationExtension::class, $paginationExtension);
        $this->assertTrue($container->has(PaginationExtensionInterface::class));
    }

    public function testReaderExtensionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $readerExtension = $container->get('mobizel_markdown_docs.twig.extension.reader');
        $this->assertInstanceOf(ReaderExtension::class, $readerExtension);
        $this->assertTrue($container->has(ReaderContextInterface::class));
    }

    public function testIndexActionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $indexAction = $container->get('mobizel_markdown_docs.controller.index_action');
        $this->assertInstanceOf(IndexAction::class, $indexAction);
    }

    public function testPageActionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $pageAction = $container->get('mobizel_markdown_docs.controller.page_action');
        $this->assertInstanceOf(PageAction::class, $pageAction);
    }

    public function testSearchActionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $searchAction = $container->get('mobizel_markdown_docs.controller.search_action');
        $this->assertInstanceOf(SearchAction::class, $searchAction);
    }

    public function testMenuActionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $menuAction = $container->get('mobizel_markdown_docs.controller.menu_action');
        $this->assertInstanceOf(MenuAction::class, $menuAction);
    }

    public function testContextLoaderWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::getContainer();

        $indexAction = $container->get('mobizel_markdown_docs.routing.context_loader');
        $this->assertInstanceOf(ContextLoader::class, $indexAction);
    }
}
