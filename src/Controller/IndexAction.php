<?php

/*
 * This file is part of test-bundle.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class IndexAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirectToRoute('mobizel_markdown_docs_page_show', ['slug' => 'index']);
    }
}
