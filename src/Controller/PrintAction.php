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

use Mobizel\Bundle\MarkdownDocsBundle\DataProvider\PageCollectionDataProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class PrintAction extends AbstractController
{
    private PageCollectionDataProviderInterface $pageCollectionDataProvider;

    public function __construct(PageCollectionDataProviderInterface $pageCollectionDataProvider)
    {
        $this->pageCollectionDataProvider = $pageCollectionDataProvider;
    }

    public function __invoke(): Response
    {
        return $this->render('@MobizelMarkdownDocs/print/index.html.twig', [
            'pages' => $this->pageCollectionDataProvider->getPages(),
        ]);
    }
}
