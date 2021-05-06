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

    /** @var array */
    private $requirements;

    public function __construct(string $name, string $path, string $dir, array $requirements = [])
    {
        $this->name = $name;
        $this->path = $path;
        $this->docsDir = $dir;
        $this->requirements = $requirements;
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
        $docsDir = $this->docsDir;

        if (count($this->getRequirements()) > 0) {
            $routeParameters = $request->get('_route_params');

            foreach ($this->getRequirements() as $parameter => $parameterPattern) {
                $replacementPattern = sprintf('/\{%s\}/', $parameter);

                if (preg_match($replacementPattern, $docsDir)) {
                    $docsDir = (string) preg_replace($replacementPattern, $routeParameters[$parameter], $docsDir);
                }
            }
        }

        return $docsDir;
    }

    public function getRequirements(): array
    {
        return $this->requirements;
    }

    public function getPattern(): string
    {
        $path = $this->getPath();

        if (count($this->getRequirements()) > 0) {
            foreach ($this->getRequirements() as $parameter => $parameterPattern) {
                $replacementPattern = sprintf('/\{%s\}/', $parameter);

                if (preg_match($replacementPattern, $path)) {
                    $path = (string) preg_replace($replacementPattern, $parameterPattern, $path);
                }
            }
        }

        return $this->buildPattern($path);
    }

    private function buildPattern(string $pattern): string
    {
        return sprintf('/%s/', str_replace('/', '\\/', $pattern));
    }
}
