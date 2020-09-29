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

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Template;

use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandler;
use PhpSpec\ObjectBehavior;

class TemplateHandlerSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('/path/to/docs');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(TemplateHandler::class);
    }

    function it_can_get_template_path(): void
    {
        $this->getTemplatePath('docs/foo')->shouldReturn('docs/foo.md');
    }

    function it_can_get_template_absolute_path(): void
    {
        $this->getTemplateAbsolutePath('docs/foo')->shouldReturn('/path/to/docs/foo.md');
    }
}
