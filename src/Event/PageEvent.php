<?php

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\Event;

use Mobizel\Bundle\MarkdownDocsBundle\Dto\PageOutput;
use Symfony\Contracts\EventDispatcher\Event;

final class PageEvent extends Event
{
    private PageOutput $page;

    public function __construct(PageOutput $page)
    {
        $this->page = $page;
    }

    public function getPage(): PageOutput
    {
        return $this->page;
    }
}
