<?php

namespace App\Service\ShopwareAdminApi;

use Symfony\Component\Cache\Adapter\AdapterInterface;

interface AuthenticatorInterface
{
    /**
     * @param string $username
     * @param string $password
     * @param CustomHttpClientInterface $shopwareClient
     * @param AdapterInterface $cache
     */
    public function __construct(
        string $username,
        string $password,
        CustomHttpClientInterface $shopwareClient,
        AdapterInterface $cache
    );

    /**
     * @return void
     */
    public function withBearerAuthentication(): void;
}
