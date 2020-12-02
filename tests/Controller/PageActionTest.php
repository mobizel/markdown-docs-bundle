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

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PageActionTest extends WebTestCase
{
    public function testRedirection()
    {
        $client = static::createClient();

        $client->request('GET', 'bdd.md');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals('/bdd', $client->getResponse()->getTargetUrl());
    }

    public function testShowPage()
    {
        $client = static::createClient();

        $client->request('GET', 'index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Documentation');
    }

    public function testNotFoundPage()
    {
        $client = static::createClient();

        $client->request('GET', 'not-found');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
