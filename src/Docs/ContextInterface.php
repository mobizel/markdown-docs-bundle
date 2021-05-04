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

interface ContextInterface
{
    public function getName(): string;

    public function getPath(): string;

    public function getDocsDir(Request $request): string;

    public function getPattern(): ?string;
}
