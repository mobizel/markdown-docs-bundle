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

use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Error\LoaderError;

final class PageAction extends AbstractController
{
    /** @var TemplateHandlerInterface */
    private $templateHandler;

    public function __construct(TemplateHandlerInterface $templateHandler)
    {
        $this->templateHandler = $templateHandler;
    }

    public function __invoke(string $slug): Response
    {
        if (false !== strpos($slug, '.md')) {
            $slug = preg_replace('/\.md$/', '', $slug);

            return $this->redirectToRoute('mobizel_markdown_docs_page_show', ['slug' => $slug]);
        }

        try {
            $templatePath = $this->templateHandler->getTemplateAbsolutePath($slug);

            if (!is_file($templatePath)) {
                throw new NotFoundHttpException(sprintf('Template %s does not exist', $templatePath));
            }

            return $this->render('@MobizelMarkdownDocs/page/show.html.twig', [
                'slug' => $slug,
                'template' => $this->templateHandler->getTemplatePath($slug),
                'content' => file_get_contents($templatePath),
            ]);
        } catch (LoaderError $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }
    }
}
