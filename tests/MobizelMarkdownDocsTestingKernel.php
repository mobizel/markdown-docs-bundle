<?php

namespace Mobizel\Bundle\MarkdownDocsBundle\Tests;

use Mobizel\Bundle\MarkdownDocsBundle\MobizelMarkdownDocsBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class MobizelMarkdownDocsTestingKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new MobizelMarkdownDocsBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}
