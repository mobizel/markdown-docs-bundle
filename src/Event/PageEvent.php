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

namespace Mobizel\Bundle\MarkdownDocsBundle\Event;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Dto\PageOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

final class PageEvent extends Event
{
    private Request $request;
    private PageOutput $page;
    private ContextInterface $context;

    public function __construct(Request $request, PageOutput $page, ContextInterface $context)
    {
        $this->request = $request;
        $this->page = $page;
        $this->context = $context;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getPage(): PageOutput
    {
        return $this->page;
    }

    public function getContext(): ContextInterface
    {
        return $this->context;
    }
}
