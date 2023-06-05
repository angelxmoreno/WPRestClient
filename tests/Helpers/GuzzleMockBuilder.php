<?php

declare(strict_types=1);

namespace WPRestClient\Test\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class GuzzleMockBuilder
{
    public static function withResponse($body = null, int $status = 200, array $headers = []): Client
    {
        $mock = new MockHandler([
            new Response($status, $headers, $body),
        ]);

        $handlerStack = HandlerStack::create($mock);
        return new Client(['handler' => $handlerStack]);
    }

    public static function withFixture(string $name, int $status = 200, array $headers = []): Client
    {
        $data = Fixture::load($name);
        $json = json_encode($data);
        return self::withResponse($json);
    }
}
