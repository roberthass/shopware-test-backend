<?php

namespace App\Service\ShopwareAdminApi;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class Authenticator implements AuthenticatorInterface
{
    const string OAUTH_TOKEN_URI = '/api/oauth/token';

    /**
     * @param string $username
     * @param string $password
     * @param CustomHttpClientInterface $httpClient
     * @param AdapterInterface $cache
     */
    public function __construct(
        private readonly string                    $username,
        private readonly string                    $password,
        private readonly CustomHttpClientInterface $httpClient,
        private readonly AdapterInterface          $cache
    )
    {
    }

    /**
     * enables Bearer (OIDC2) Authentication for the following requests, fetches the token from cache if available or from token endpoint
     * @return void
     * @throws InvalidArgumentException
     */
    public function withBearerAuthentication(): void
    {
        $cacheItem = $this->cache->getItem($this->generateCacheKey($this->username . $this->password));

        if (!$cacheItem->isHit()) {
            $cacheItem->set($this->authenticate());
            $this->cache->save($cacheItem);
        }

        $this->httpClient->setBearerToken($cacheItem->get());
    }

    /**
     * hashes the inputString with sha256
     * @param string $input
     * @return string
     */
    private function generateCacheKey(string $input): string
    {
        return hash('sha256', $input);
    }

    /**
     * authenticates the user and return the token
     * @return string
     */
    private function authenticate(): string
    {
        $response = $this->httpClient->sendPlainRequest(
            'POST',
            self::OAUTH_TOKEN_URI,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    'client_id' => 'administration',
                    'grant_type' => 'password',
                    'username' => $this->username,
                    'password' => $this->password,
                ])
            ]
        );

        return json_decode($response, true)['access_token'];
    }
}
