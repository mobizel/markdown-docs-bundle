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

namespace spec\Mobizel\Bundle\MarkdownDocsBundle\Docs;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\Context;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class ContextSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('default', '/docs', './docs', []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Context::class);
    }

    public function it_can_get_path(): void
    {
        $this->getPath()->shouldReturn('/docs');
    }

    public function it_can_get_pattern(): void
    {
        $this->beConstructedWith('legacy', '/{project}/{version}', './legacy_docs/{project}/{version}', [
            'project' => '(\w+)',
            'version' => '(\d+).(\d+)',
        ]);

        $this->getPattern()->shouldReturn('/\/(\w+)\/(\d+).(\d+)/');
    }

    public function it_can_get_metadata(Request $request, ParameterBag $attributesBag): void
    {
        $attributesBag->get('_route_params')->willReturn([]);

        $request->attributes = $attributesBag;

        $this->beConstructedWith('legacy', '/{project}/{version}', './legacy_docs/{project}/{version}', [], [
            'title' => '{package} documentation',
        ]);

        $this->getMetadata($request)->shouldReturn([
            'title' => '{package} documentation',
        ]);
    }

    public function it_can_get_docs_dir(Request $request, ParameterBag $attributesBag): void
    {
        $attributesBag->get('_route_params')->willReturn([]);

        $request->attributes = $attributesBag;

        $this->getDocsDir($request)->shouldReturn('./docs');
    }

    public function it_replaces_params_in_docs_dir(Request $request, ParameterBag $attributesBag): void
    {
        $this->beConstructedWith('legacy', '/{project}/{version}', './docs/{project}/{version}', [
            'project' => '(\w+)',
            'version' => '(\d+).(\d+)',
        ]);

        $attributesBag->get('_route_params')->willReturn([
            'project' => 'my-project',
            'version' => '1.2',
        ]);

        $request->attributes = $attributesBag;

        $this->getDocsDir($request)->shouldReturn('./docs/my-project/1.2');
    }
}
