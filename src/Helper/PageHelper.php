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

namespace Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\Page\Page;
use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;

final class PageHelper implements PageHelperInterface
{
    /** @var TemplateHandlerInterface */
    private $templateHandler;

    public function __construct(TemplateHandlerInterface $templateHandler)
    {
        $this->templateHandler = $templateHandler;
    }

    public function getTitle(string $slug): string
    {
        $path = $this->templateHandler->getTemplateAbsolutePath($slug);
        $page = new Page($path);

        return $page->getTitle();
    }
}
