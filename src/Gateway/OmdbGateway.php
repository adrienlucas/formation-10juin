<?php
declare(strict_types=1);

namespace App\Gateway;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbGateway
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {}

    private string $apiKey = 'e0ded5e2';

    public function getMovieByTitle(string $title): array
    {
        $apiUrl = sprintf(
            'https://www.omdbapi.com/?apikey=%s&t=%s',
            $this->apiKey,
            $title
        );
        $response = $this->httpClient->request('GET', $apiUrl);

        return array_intersect_key(
            $response->toArray(),
            ['Released' => null, 'Director' => null]
        );
    }
}