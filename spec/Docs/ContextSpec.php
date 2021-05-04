<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Docs;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\Context;
use PhpSpec\ObjectBehavior;

class ContextSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('default', '/docs', './docs');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Context::class);
    }

    public function it_can_get_path(): void
    {
        $this->getPath()->shouldReturn('/docs');
    }

    public function it_can_get_docs_dir(): void
    {
        $this->getDocsDir()->shouldReturn('./docs');
    }
}
