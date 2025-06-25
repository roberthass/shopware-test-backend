<?php

namespace App\Service\ShopwareAdminApi;

use App\Model\Product;

readonly class Fetcher
{
    /**
     * @param CustomHttpClientInterface $httpClient
     * @param AuthenticatorInterface $authenticator
     */
    public function __construct(
        private CustomHttpClientInterface $httpClient,
        private AuthenticatorInterface    $authenticator,
    )
    {
    }

    /**
     * fetches the production api with pre authentication
     * @return Product[]
     */
    public function getProducts(): array
    {
        $this->authenticator->withBearerAuthentication();
        $responseBody = $this->httpClient->sendFullRequest('GET', '/api/product');
        $data = json_decode($responseBody, true)['data'];

        return array_map(fn (array $product) => Product::createFromApiArray($product), $data);
    }
}
