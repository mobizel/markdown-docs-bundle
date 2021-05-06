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

namespace Mobizel\Bundle\MarkdownDocsBundle\Controller;

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SearchAction extends AbstractController
{
    /** @var ReaderContextInterface */
    private $readerContext;

    public function __construct(ReaderContextInterface $readerContext)
    {
        $this->readerContext = $readerContext;
    }

    public function __invoke(Request $request): Response
    {
        $query = $request->get('query', '');

        $finder = new Finder();
        $finder->files()->in($this->readerContext->getContext()->getDocsDir($request))->contains('/'.$query.'/i');

        return $this->render('@MobizelMarkdownDocs/search/index.html.twig', [
            'files' => $finder,
        ]);
    }
}
