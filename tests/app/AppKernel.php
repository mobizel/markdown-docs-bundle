<?php

namespace Mobizel\Bundle\MarkdownDocsBundle\Tests\app;

use Mobizel\Bundle\MarkdownDocsBundle\MobizelMarkdownDocsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Twig\Extra\TwigExtraBundle\TwigExtraBundle;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new MobizelMarkdownDocsBundle(),
            new TwigBundle(),
            new TwigExtraBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config.yaml');
    }
}
