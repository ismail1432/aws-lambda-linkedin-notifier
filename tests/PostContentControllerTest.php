<?php

namespace App\Test;

use App\Controller\PostContentController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Notifier;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class PostContentControllerTest extends WebTestCase
{
    /**
     * @dataProvider methodProvider
     */
    public function testANoPostRequestShouldReturnA405(string $method)
    {
        $client = static::createClient();

        $client->request($method, '/contents');

        self::assertEquals(405, $client->getResponse()->getStatusCode());
    }

    public function testAPostRequestWithoutAMessageInBodyShouldReturnA400()
    {
        $client = static::createClient();

        $client->request('POST', '/contents');

        self::assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testAPostRequestWithAMessageInBodyShouldReturnA201()
    {
        $request = new Request([],[],[],[],[],[], json_encode(['message' => 'Hello World']));

        $notifier = new class implements NotifierInterface {
            public function send(Notification $notification, Recipient ...$recipients): void
            {
            }
        };

        $controller = new PostContentController();
        $response = $controller->__invoke($notifier, $request);

        self::assertEquals(201, $response->getStatusCode());
    }

    public function methodProvider()
    {
        return [
            ['GET'],
            ['PUT'],
            ['DELETE'],
        ];
    }
}
