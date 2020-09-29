<?php

/*
 * This file is part of the Mobizel package.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension;

use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\PageTitleExtension;
use PhpSpec\ObjectBehavior;
use Twig\Extension\ExtensionInterface;

class PageTitleExtensionSpec extends ObjectBehavior
{
    function let(TemplateHandlerInterface $templateHandler): void
    {
        $this->beConstructedWith($templateHandler);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageTitleExtension::class);
    }

    function it_is_a_twig_extension(): void
    {
        $this->shouldImplement(ExtensionInterface::class);
    }

    function it_has_twig_functions(): void
    {
        $this->getFunctions()->shouldHaveCount(1);
    }

    function it_can_get_page_title(TemplateHandlerInterface $templateHandler): void
    {
        $templateHandler->getTemplateAbsolutePath('foo')->willReturn(__DIR__.'/dummy/foo.md');

        $this->pageTitle('foo')->shouldReturn('Foo fighters');
    }

    function it_return_default_title_when_no_title_has_been_found(TemplateHandlerInterface $templateHandler): void
    {
        $templateHandler->getTemplateAbsolutePath('bar')->willReturn(__DIR__.'/dummy/bar.md');

        $this->pageTitle('bar')->shouldReturn('Bar');
    }

    function it_return_default_title_when_file_is_empty(TemplateHandlerInterface $templateHandler): void
    {
        $templateHandler->getTemplateAbsolutePath('bar')->willReturn(__DIR__.'/dummy/empty.md');

        $this->pageTitle('bar')->shouldReturn('Bar');
    }
}
