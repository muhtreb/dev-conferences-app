<?php

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiClient
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client, private string $baseUrl)
    {
        $this->client = $client->withOptions([
            'base_uri' => $this->baseUrl,
            'verify_peer' => false,
        ]);
    }

    public function getConferences(int $limit = 10, int $offset = 0): array
    {
        return $this->client->request('GET', '/conferences',
            [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                ]
            ]
        )->toArray();
    }

    public function getConferenceBySlug(string $slug): array
    {
        return $this->client->request('GET', '/conferences/slug/' . $slug)->toArray();
    }

    public function getSearchConferencesResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/conferences/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page,
            ]
        ]);
    }

    public function getLatestEditions(int $limit = 12): array
    {
        return $this->getLatestEditionsResponse($limit)->toArray();
    }

    public function getLatestEditionsResponse(int $limit = 12): ResponseInterface
    {
        return $this->client->request('GET', '/conferences/editions/latest', [
            'query' => [
                'limit' => $limit,
            ]
        ]);
    }

    public function getEditions(int $limit = 10, int $offset = 0): array
    {
        return $this->client->request('GET', '/conferences/editions', [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ]
        ])->toArray();
    }

    public function getSearchEditionsResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/conferences/editions/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page
            ]
        ]);
    }

    public function getConferenceEditions(string $id): array
    {
        return $this->client->request('GET', '/conferences/' . $id . '/editions')->toArray();
    }

    public function getEditionBySlug(string $slug): array
    {
        return $this->client->request('GET', '/conferences/editions/slug/' . $slug)->toArray();
    }

    public function getSearchTalksResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/talks/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page
            ]
        ]);
    }

    public function getTalkBySlug(string $slug): array
    {
        return $this->client->request('GET', '/talks/slug/' . $slug)->toArray();
    }

    public function getSearchSpeakersResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/speakers/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page
            ]
        ]);
    }

    public function getTopSpeakers(int $limit = 10): array
    {
        return $this->getTopSpeakersResponse($limit)->toArray();
    }

    public function getTopSpeakersResponse(int $limit = 10): ResponseInterface
    {
        return $this->client->request('GET', '/speakers/top', [
            'query' => [
                'limit' => $limit,
            ]
        ]);
    }

    public function getSpeakerBySlug(string $slug): array
    {
        return $this->client->request('GET', '/speakers/slug/' . $slug)->toArray();
    }

    public function getSpeakers(int $limit = 10, int $offset = 0): array
    {
        return $this->client->request('GET', '/speakers', [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ]
        ])->toArray();
    }
}
