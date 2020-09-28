<?php

/*
 * This file is part of markdown-docs-bundle.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PageActionTest extends WebTestCase
{
    public function testRedirection()
    {
        $client = static::createClient();

        $client->request('GET', '/docs/index.md');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testShowPage()
    {
        $client = static::createClient();

        $client->request('GET', '/docs/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Documentation');
    }

    public function testNotFoundPage()
    {
        $client = static::createClient();

        $client->request('GET', '/docs/not-found');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
