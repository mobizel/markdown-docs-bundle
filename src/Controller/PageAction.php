<?php

/*
 * This file is part of markdown-docs.
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
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;

final class PageAction extends AbstractController
{
    /** @var TemplateHandlerInterface */
    private $templateHandler;

    public function __construct(TemplateHandlerInterface $templateHandler)
    {
        $this->templateHandler = $templateHandler;
    }

    /**
     * @Route("{slug}", name="mobizel_markdown_docs_page_show", requirements={"slug"="docs/.+"}, priority=-999)
     */
    public function __invoke(string $slug): Response
    {
        if (false !== strpos($slug, '.md')) {
            return $this->redirectToRoute('mobizel_markdown_docs_page_show', ['slug' => rtrim($slug, '.md')]);
        }

        try {
            $templatePath = $this->templateHandler->getTemplateAbsolutePath($slug);

            return $this->render('page/show.html.twig', [
                'slug' => $slug,
                'template' => $this->templateHandler->getTemplatePath($slug),
                'content' => file_get_contents($templatePath),
            ]);
        } catch (LoaderError $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }
    }
}
