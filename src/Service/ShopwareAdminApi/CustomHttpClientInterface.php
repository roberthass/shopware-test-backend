<?php

namespace App\Service\ShopwareAdminApi;

interface CustomHttpClientInterface
{
    /**
     * @param string $token
     * @return void
     */
    public function setBearerToken(string $token): void;

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return string
     */
    public function sendFullRequest(string $method, string $url, array $options = []): string;

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return string
     */
    public function sendPlainRequest(string $method, string $url, array $options = []): string;
}
