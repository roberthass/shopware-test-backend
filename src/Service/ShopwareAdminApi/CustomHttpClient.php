<?php

namespace App\Service\ShopwareAdminApi;

use JsonException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomHttpClient implements CustomHttpClientInterface
{
    private ?string $bearerToken = null;

    /**
     * @param string $baseUrl
     * @param HttpClientInterface $client
     */
    public function __construct(
        private readonly string     $baseUrl,
        private readonly HttpClientInterface $client
    )
    {}

    /**
     * set Bearer Token
     * @param string $token
     * @return void
     */
    public function setBearerToken(string $token): void
    {
        $this->bearerToken = $token;
    }

    /**
     * send the request with full set options configured in this class
     * @param string $method
     * @param string $url
     * @param array $options
     * @return string
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendFullRequest(string $method, string $url, array $options = []): string
    {
        $addedOptions = $this->addAuthenticationHeader($options);

        return $this->sendPlainRequest($method, $url, $addedOptions);
    }

    /**
     * add authentication header to the options array
     * @param array $options
     * @return array
     */
    private function addAuthenticationHeader(array $options): array
    {
        $headers = $options['headers'] ?? [];

        if ($this->bearerToken !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->bearerToken;
        }

        $options['headers'] = $headers;

        return $options;
    }

    /**
     * send request only with the given options
     * @param string $method
     * @param string $url
     * @param array $options
     * @return string
     * @throws JsonException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendPlainRequest(string $method, string $url, array $options = []): string
    {
        $response = $this->client->request($method, $this->baseUrl . $url, $options);

        if ($response->getStatusCode() !== 200) {
            $errorContent = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);
            if (isset($errorContent['errors'])) {
                foreach ($errorContent['errors'] as $error) {
                    throw new BadRequestException($error['title'] . ' - ' . $error['detail'], $error['status']);
                }
            }
        }
        return $response->getContent();
    }
}
