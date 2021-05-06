<?php

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Docs;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\Context;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

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

    public function it_can_get_docs_dir(Request $request): void
    {
        $request->get('_route_params')->willReturn([]);

        $this->getDocsDir($request)->shouldReturn('./docs');
    }

    public function it_replaces_params_in_docs_dir(Request $request): void
    {
        $this->beConstructedWith('legacy', '/{version}', './legacy_docs/{version}', '(\d+).(\d+)');

        $request->get('_route_params')->willReturn([
            'version' => '1.2',
        ]);

        $this->getDocsDir($request)->shouldReturn('./legacy_docs/1.2');
    }
}
