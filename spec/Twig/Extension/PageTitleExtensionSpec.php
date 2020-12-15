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

use Mobizel\Bundle\MarkdownDocsBundle\Helper\PageHelperInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Twig\Extension\PageTitleExtension;
use PhpSpec\ObjectBehavior;
use Twig\Extension\ExtensionInterface;

class PageTitleExtensionSpec extends ObjectBehavior
{
    function let(PageHelperInterface $pageHelper): void
    {
        $this->beConstructedWith($pageHelper);
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

    function it_can_get_title(PageHelperInterface $pageHelper): void
    {
        $pageHelper->getTitle('jimmy-page')->willReturn('Jimmy Page');

        $this->pageTitle('jimmy-page')->shouldReturn('Jimmy Page');
    }
}
