<?php

declare(strict_types=1);

namespace Tests\TheRichCourt\TranslationsTestingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

/**
 * @internal
 */
final class TranslationsTestingControllerTest extends WebTestCase
{
    public function testIndexAction(): void
    {
        $client = static::createClient();

        /** @var RouterInterface */
        $router = static::$container->get('router');

        $client->request('GET', $router->generate('translations_test_index'));

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
