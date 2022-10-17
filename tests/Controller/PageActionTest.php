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

namespace Mobizel\Bundle\MarkdownDocsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PageActionTest extends WebTestCase
{
    public function testRedirection(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/bar.md');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals('/current/bar', $client->getResponse()->getTargetUrl());
    }

    public function testDirectoryIndexPageRedirection(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/products/books/index');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals('/current/products/books', $client->getResponse()->getTargetUrl());
    }

    public function testShowPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Documentation');
    }

    public function testImage():void
    {
        $client = static::createClient();

        $client->request("GET","/current/products/books/stephen-king/img1.jpeg");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->request("GET","/current/products/../products/books/stephen-king/img1.jpeg");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->request("GET","/current/not-found.jpeg");
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testShowPageWithContextContainingOneRequirement(): void
    {
        $client = static::createClient();

        $client->request('GET', '/1.2/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Documentation for 1.2 release');
    }

    public function testShowPageWithContextContainingTwoRequirements(): void
    {
        $client = static::createClient();

        $client->request('GET', '/packages/destroyer/1.2/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Destroyer');
    }

    public function testShowPageWithMetadata(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('.navbar-brand', 'Documentation');
    }

    public function testShowPageWithMetadataContainingOneRequirement(): void
    {
        $client = static::createClient();

        $client->request('GET', '/packages/destroyer/1.2/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('.navbar-brand', 'Destroyer');
    }

    public function testDirectoryIndexPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/products/books');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Book homepage');
    }

    public function testShowPageWithTrailingSlash(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/products/books/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Book homepage');
    }

    public function testSubDirectoryIndexPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/products/books/stephen-king');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Stephen King Books');
    }

    public function testNotFoundPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/not-found');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testBreadcrumb(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/cookbook/bdd/phpspec');

        $client->clickLink('BDD - Behaviour-driven development');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'BDD - Behaviour-driven development');
    }
}
