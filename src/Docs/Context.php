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

namespace Mobizel\Bundle\MarkdownDocsBundle\Docs;

use Symfony\Component\HttpFoundation\Request;

final class Context implements ContextInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $path;

    /** @var string */
    private $docsDir;

    /** @var string|null */
    private $pattern;

    public function __construct(string $name, string $path, string $dir, ?string $pattern = null)
    {
        $this->name = $name;
        $this->path = $path;
        $this->docsDir = $dir;
        $this->pattern = $pattern;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDocsDir(Request $request): string
    {
        if (null !== $this->pattern) {
            $routeParameters = $request->get('_route_params');

            if (preg_match('/\{(.+)\}/', $this->docsDir, $matches)) {
                $parameterKey = $matches[1];
                return preg_replace('/\{(.+)\}/', $routeParameters[$parameterKey], $this->docsDir);
            }
        }

        return $this->docsDir;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }
}
