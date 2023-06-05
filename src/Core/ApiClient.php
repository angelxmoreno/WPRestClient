<?php

declare(strict_types=1);

namespace WPRestClient\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use WPRestClient\Test\Helpers\Fixture;

class ApiClient
{
    protected string $base_uri;
    protected Client $httpClient;
    protected ?AuthInterface $auth = null;
    protected string $api_prefix = 'wp-json/wp/v2';

    /**
     * @param string $baseUri
     * @param Client|null $httpClient
     * @param AuthInterface|null $auth
     */
    public function __construct(string $baseUri, ?Client $httpClient = null, ?AuthInterface $auth = null)
    {
        $this->base_uri = trim($baseUri, '/');
        $this->httpClient = $httpClient ?? new Client();
        $this->auth = $auth;
    }

    /**
     * @return string
     */
    public function getApiPrefix(): string
    {
        return $this->api_prefix;
    }

    /**
     * @return AuthInterface|null
     */
    public function getAuth(): ?AuthInterface
    {
        return $this->auth;
    }

    /**
     * @param AuthInterface|null $auth
     */
    public function setAuth(?AuthInterface $auth): void
    {
        $this->auth = $auth;
    }

    protected function buildFullUri(string $uri): string
    {
        return sprintf('%s/%s/%s', $this->base_uri, $this->getApiPrefix(), trim($uri, '/'));
    }

    /**
     * @throws GuzzleException
     */
    public function sendRequest(string $method, string $uri, array $data = []): array
    {
        $url = $this->buildFullUri($uri);
        if (strtolower($method) === 'get') {
            $url .= http_build_query($data);
        }
        $request = new Request($method, $url);
        if ($this->getAuth()) {
            $request = $this->getAuth()->withAuth($request);
        }
        return $this->doRequest($request);
    }

    /**
     * @throws GuzzleException
     */
    public function doRequest(RequestInterface $request): array
    {

        $response = $this->httpClient->send($request);
        $jsonString = $response->getBody()->getContents();
//        Fixture::generate(str_replace('/', '.', trim($request->getUri()->getPath(), '/')), json_decode($jsonString, true));
        return json_decode($jsonString, true);
    }
}
