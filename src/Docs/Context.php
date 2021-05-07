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
    private string $name;
    private string $path;
    private string $docsDir;
    private array $requirements;
    private array $metadata;

    public function __construct(
        string $name,
        string $path,
        string $dir,
        array $requirements = [],
        array $metadata = []
    ) {
        $this->name = $name;
        $this->path = $path;
        $this->docsDir = $dir;
        $this->requirements = $requirements;
        $this->metadata = $metadata;
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
        $routeParameters = $request->get('_route_params');

        return $this->replaceMatchingParametersWithRouteParameters($this->docsDir, $routeParameters);
    }

    public function getRequirements(): array
    {
        return $this->requirements;
    }

    public function getPattern(): string
    {
        $path = $this->getPath();

        foreach ($this->getRequirements() as $parameter => $parameterPattern) {
            $replacementPattern = sprintf('/\{%s\}/', $parameter);

            if (preg_match($replacementPattern, $path)) {
                $path = (string) preg_replace($replacementPattern, $parameterPattern, $path);
            }
        }

        return $this->buildPattern($path);
    }

    public function getMetadata(Request $request): array
    {
        $metadata = $this->metadata;

        $routeParameters = $request->get('_route_params');

        foreach ($metadata as $key => $data) {
            if (!\is_string($data)) {
                continue;
            }

            $metadata[$key] = $this->replaceMatchingParametersWithRouteParameters($data, $routeParameters);
        }

        return $metadata;
    }

    private function buildPattern(string $pattern): string
    {
        return sprintf('/%s/', str_replace('/', '\\/', $pattern));
    }

    private function replaceMatchingParametersWithRouteParameters(string $data, array $routeParameters): string
    {
        foreach ($this->getRequirements() as $parameter => $parameterPattern) {
            $replacementPattern = sprintf('/\{%s\}/', $parameter);

            if (preg_match($replacementPattern, $data)) {
                $data = (string) preg_replace($replacementPattern, $routeParameters[$parameter], $data);
            }
        }

        return $data;
    }
}
