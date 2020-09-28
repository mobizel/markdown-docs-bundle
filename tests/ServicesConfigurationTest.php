<?php

/*
 * This file is part of markdown-docs-bundle.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\Tests;

use Mobizel\Bundle\MarkdownDocsBundle\Controller\PageAction;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandler;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\PageTitleExtensionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ServicesConfigurationTest extends KernelTestCase
{
    public function testTemplateHandlerWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::$container;

        $templateHandler = $container->get('mobizel_markdown_docs.template.template_handler');
        $this->assertInstanceOf(TemplateHandler::class, $templateHandler);
        $this->assertTrue($container->has(TemplateHandlerInterface::class));
    }

    public function testPageTitleExtensionWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::$container;

        $pageTitleExtension = $container->get('mobizel_markdown_docs.twig.extension.page_title');
        $this->assertInstanceOf(PageTitleExtensionInterface::class, $pageTitleExtension);
        $this->assertTrue($container->has(PageTitleExtensionInterface::class));
    }

    public function testPageActionControllerWiringWithConfiguration()
    {
        self::bootKernel();

        $container = self::$container;

        $pageAction = $container->get('mobizel_markdown_docs.controller.page_action');
        $this->assertInstanceOf(PageAction::class, $pageAction);
    }
}
